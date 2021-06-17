<template>
    <div class="m-3 md:m-5">
        <div>
            <div class="flex justify-end">
                <button @click="createModal = true" class="bg-green-600 text-white px-2 py-1 rounded shadow mx-1">Create</button>
                    <!-- start create modal -->
                <div v-show="createModal" tabindex="0" class="transition duration-500 ease-in-out z-40 left-1/4 top-1/4 bottom-1/4 right-1/4 w-50 fixed">
                    <div class="z-50 relative p-3 mx-auto my-0 md:w-3/4">
                        <div class="bg-white rounded shadow-lg border flex flex-col overflow-hidden">
                            <button @click="createModal = false" class="fill-current h-6 w-6 absolute right-0 top-0 m-6 font-3xl font-bold"><i class="fas fa-times"></i></button>
                            <div class="px-6 py-3 text-xl border-b font-bold">Create</div>
                            <div class="p-6">
                                <div>
                                    <label for="file_upload" class="px-3 py-2 text-gray-900 transition-colors duration-150 border border-indigo-500 rounded-lg focus:shadow-outline hover:bg-blue-800 hover:text-indigo-100">Upload Logo</label>
                                    <input type="file" id="file_upload" @change="attach($event, 'file_upload', 'display_span', 'display_image')" class="hidden">
                                    <span id="display_span" class="px-3 py-2"></span>
                                    <div class="w-80 p-3 shadow rounded">
                                        <img id="display_image" src="" alt="" class="w-full">
                                    </div>
                                    <button v-if="file_attached" @click="deAttach('display_span')" class="px-3 py-2 text-gray-900 transition-colors duration-150 border border-indigo-500 rounded-lg focus:shadow-outline hover:bg-blue-800 hover:text-indigo-100">Remove</button>
                                    <button v-if="file_attached" @click="upload('display_span')" class="px-3 py-2 text-gray-900 transition-colors duration-150 border border-indigo-500 rounded-lg focus:shadow-outline hover:bg-blue-800 hover:text-indigo-100" :disabled="buttons.upload.disabled">{{ buttons.upload.text }}</button>
                                </div>
                                <div>
                                    <input type="file" name="" id="background">
                                    <label for="background"></label>
                                </div>
                                <div>
                                    <input type="tel" name="" id="contact">
                                    <label for="contact"></label>
                                </div>
                                <div>
                                    <input type="text" name="" id="title">
                                    <label for="title"></label>
                                </div>
                                <div>
                                    <textarea name="" id="description"></textarea>
                                    <label for="description"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <table class="table-auto">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Logo</th>
                            <th>Background</th>
                            <th>Contact</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(poster, index) in posters" :key="index">
                            <td>{{ index + 1 }}</td>
                            <td>{{ poster.title }}</td>
                            <td> <img :src="'/storage/poster/{user_id}/{post_id}/logo/' + poster.logo" alt="logo"></td>
                            <td><img :src="'/storage/poster/{user_id}/{post_id}/background/' + poster.background" alt="background"></td>
                            <td>{{ poster.contact }}</td>
                            <td>
                                <button class="bg-blue-600 text-white px-2 py-1 rounded shadow mx-1">Edit</button>
                                <button class="bg-red-600 text-white px-2 py-1 rounded shadow mx-1">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
</template>

<script>
export default {
    props: {
        posters_prop: Array
    },
    data() {
        return {
            posters : [],
            newPoster : {
                logo: ''
            },
            createModal : false,
            file_upload : '',
            file_attached: false,
            buttons: {
                upload : {
                    text: "Upload",
                    disabled: false
                },
                download : {
                    text: "Download",
                    disabled: false
                },
                remove : {
                    text: "Remove",
                    disabled: false
                },
            },
        }
    },
    created() {
        this.setPosters();
    },
    methods: {
        setPosters () {
            this.posters = this.posters_prop;
        },
        attach (e, file_id = false, display_name_id = false, display_image_id = false) {
            let display_image = document.getElementById(display_image_id);
            // this.display_image_old_src = display_image.src;
                
            this.file_upload = e.target.files[0];
            let reader = new FileReader();
            reader.addEventListener('load', function () {
                display_image.src = reader.result;
            }.bind(this), false);
            reader.readAsDataURL(this.file_upload);
          if (display_name_id) {
            document.getElementById(display_name_id).innerHTML = this.icon(this.file_upload.name)+this.file_upload.name;
          }
          if (this.file_upload != "") {
            this.file_attached = true;
          }
        },

        deAttach (display_id = false) {
          this.file_upload = "";
          this.file_attached = false;
          if (display_id) {
            document.getElementById(display_id).innerHTML = "";
          }
        },
                upload (display_id = false) {
          this.buttons.upload.text = 'Uploading...';
          this.buttons.upload.disabled = true;
          let formData = new FormData;
          formData.append('file_upload', this.file_upload);
          formData.append('event_id', this.event_prop.id);
          axios.post('/event-uploads', formData).then((response) => {
            if (response.status == 200) {
              this.buttons.upload.text = 'Upload';
              this.buttons.upload.disabled = false;
              this.event_uploads.push(response.data);
              if (display_id) {
                this.deAttach(display_id);
              }
              swal({
                title: 'Success',
                text: 'File Uploaded Successfully',
                icon: 'success',
                buttons: false,
                timer: 3000
              });
            } else {
              console.warn(response.data);
            }
          }).catch((error) => {
            var message = '';
            if (error.response.status != 422) {
              message = error.response.statusText;
            } else {
              message = error.response.data.message;
            }
            this.buttons.upload.text = 'Upload';
            this.buttons.upload.disabled = false;
            swal({
              title: "Some Thing Wrong!",
              text: message,
              icon: "error",
              buttons: false,
              timer: 3000
            });
          });
        },
        
        remove (id) {

          axios.delete('/event-uploads/'+id).then((response) => {
            if (response.status == 200) {
              this.event_uploads = this.event_uploads.filter((event_upload) => {
                return event_upload.id != id;
              });
             
              swal({
                title: 'Success',
                text: 'File Deleted Successfully',
                icon: 'success',
                buttons: false,
                timer: 3000
              });
            } else {
              console.warn(response.data);
            }
          }).catch((error) => {
            
            swal({
              title: "Some Thing Wrong!",
              text: error.response.statusText,
              icon: "error",
              buttons: false,
              timer: 3000
            });
          });
        },
        icon (filename) {
                var filenameArray = filename.split('.');
                var extension = filenameArray[filenameArray.length - 1];
                var icon = '';
                  switch(extension) {
                    case 'zip':
                        icon = '<i class="fas fa-file-archive mr-1" style="color:#000000;"></i>';
                        break;
                    case 'csv':
                        icon = '<i class="fas fa-file-csv mr-1" style="color:#96C3F7;"></i>';
                        break;
                    case 'xls':
                    case 'xlsx':
                        icon = '<i class="fas fa-file-excel mr-1" style="color:#217346;"></i>';
                        break;
                    case 'png': 
                    case 'PNG':
                    case 'jpeg': 
                    case 'JPEG':
                    case 'jpg': 
                    case 'JPG':
                        icon = '<i class="fas fa-file-image mr-1" style="color:#9656B0;"></i>';
                        break;
                    case 'pdf':
                        icon = '<i class="fas fa-file-pdf mr-1" style="color:#CB0F0B;"></i>';
                        break;
                    case 'ppt':
                    case 'pptx':
                        icon = '<i class="fas fa-file-powerpoint mr-1" style="color:#B53317;"></i>';
                        break;
                    case 'doc':
                    case 'docx':
                        icon = '<i class="fas fa-file-word mr-1" style="color:#285192;"></i>';
                        break;
                    default:
                    icon = '<i class="far fa-file mr-1" style="color:#000000;"></i>';
                }
                return icon;
        }
    },
}
</script>