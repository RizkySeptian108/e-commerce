<div x-data="{
    currentSlide: 0,
    totalSlides: 3,
    nextSlide() {
        this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
    },
    prevSlide() {
        this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
    }
}"
 x-init="() => { setInterval(() => nextSlide(), 5000); }" class=" rounded-md h-80 w-full overflow-hidden relative border border-red-500">

    <div class="relative">
        <div class="absolute top-0 left-0 right-100 bottom-0 bg-[url('{{ asset('img/placeholder.png') }}')] bg-f" x-show="currentSlide === 0" x-transition:enter="transform transition-transform ease-out duration-1000" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition-transform ease-in duration-1000" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">
            <!-- Slide 1 -->
            {{-- <img src="{{ asset('img/placeholder.png') }}" alt="Ad 1" class="object-fill"> --}}
        </div>
        <div class="absolute top-0 left-0 right-100 bottom-0" x-show="currentSlide === 1" x-transition:enter="transform transition-transform ease-out duration-1000" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition-transform ease-in duration-1000" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">
            <!-- Slide 2 -->
            <img src="{{ asset('img/placeholder2.png') }}" alt="Ad 2" class="object-fill">
        </div>
        <div class="absolute top-0 left-0 right-100 bottom-0" x-show="currentSlide === 2" x-transition:enter="transform transition-transform ease-out duration-1000" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition-transform ease-in duration-1000" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">
            <!-- Slide 3 -->
            <img src="{{ asset('img/placeholder3.png') }}" alt="Ad 3" class="object-fill">
        </div>
    </div>

    
    <button @click="prevSlide" class="absolute top-32 left-0 text-white p-2 bg-gray-800 hover:bg-gray-700 text-3xl opacity-40 rounded-e-md">
        <i class="fa-solid fa-angle-left"></i>
    </button>
    <button @click="nextSlide" class="absolute top-32 right-0 text-white p-2 bg-gray-800 hover:bg-gray-700 text-3xl opacity-40  rounded-s-md">
        <i class="fa-solid fa-angle-right"></i>
    </button>
    

</div>