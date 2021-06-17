<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Poster') }}
        </h2>
    </x-slot>

    <div class="border-4 border-blue-200 bg-white p-3 shadow rounded mx-auto mt-12 w-1/3">
        <div class="flex justify-between mb-3">
            <div>
                <img src="{{ asset('car_rental/logo_car_rental.png') }}" alt="logo_car_rental" class="w-36">
            </div>
            <div class="flex items-center bg-gradient-to-r from-white via-blue-100 to-green-100 ">
                <h2 class="text-blue-700 text-xl font-bold mx-2">Naran Kaghan</h2>
                <img src="{{ asset('/car_rental/tours/naran.jpg') }}" alt="naran" class="h-20">
            </div>
        </div>
        <div id="main-image">
            <img src="{{ asset('car_rental/vehicals/toyota/corolla/attitube-black.png') }}" alt="bmw" class="w-full">
            <div class="bg-gradient-to-br from-blue-200 via-green-200 to-pink-200 ">
                <div class="p-3 text-center">
                    <h1 class="text-blue-700 text-2xl font-bold">Vehical:- <span>Corolla X 2021</span></h1>
                    <h1 class="text-blue-700 text-2xl font-bold">Rate:- <span>RS:- 6000/Day</span></h1>
                </div>
                <div class="p-3 text-center">
                    <h1 class=" text-2xl font-bold">Contacts:-</h1>
                    <div>
                        {{-- <h1 class="text-green-700 text-xl font-bold"><span>Tasadaq Hussain:- 0300-9515787</span></h1> --}}
                        <h1 class="text-green-700 text-xl font-bold"><span>Amar Sarfraz:- 0333-5868894</span></h1>
                        <h1 class="text-green-700 text-xl font-bold"><span>Abdul Wahab:- 0300-5440955</span></h1>
                    </div>
                </div>
            </div>
            
        </div>
        
        
    </div>
    @section('styles')
<style>
    #main-image {

        /* background-image: url('/car_rental/tours/naran.jpg'); */
    }
</style>
@endsection

</x-app-layout>
