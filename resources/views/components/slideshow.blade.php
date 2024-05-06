<div x-data="{
    currentSlide: 1,
    totalSlide: 3,
    nextSlide: function(){
        this.currentSlide = this.currentSlide + 1 
        if(this.currentSlide > this.totalSlide){
            this.currentSlide = 1
        }
    },
    prevSlide: function(){
        this.currentSlide = this.currentSlide - 1
        if(this.currentSlide < 1){
            this.currentSlide = this.totalSlide
        }
    }
}" 
x-init="() => {
    setInterval(() => {
        let nextSlide = currentSlide + 1;
        if (nextSlide > totalSlide) {
            nextSlide = 1;
        }
        currentSlide = nextSlide;
    }, 5000); // Change 5000 to the interval you desire in milliseconds
}"
class=" rounded-md h-80 w-full relative border flex flex-row overflow-hidden border-red-500">
    <div class="absolute top-1/3 font-extrabold text-gray-300 text-6xl p-2 bg-gray-500 bg-opacity-50 cursor-pointer" x-on:click="prevSlide()"><i class="fa-solid fa-caret-left"></i></div>

    <div class="bg-cover bg-center h-full transition-all ease-in-out" :class="currentSlide == 1 ? 'w-full' : 'w-0'" style="background-image: url('{{ asset('img/placeholder.png') }}')"></div>
    <div class="bg-cover bg-center h-full transition-all ease-in-out" :class="currentSlide == 2 ? 'w-full' : 'w-0'" style="background-image: url('{{ asset('img/placeholder2.png') }}')" ></div>
    <div class="bg-cover bg-center h-full transition-all ease-in-out" :class="currentSlide == 3 ? 'w-full' : 'w-0'" style="background-image: url('{{ asset('img/placeholder3.png') }}')"></div>

    <div class="absolute top-1/3 right-0 font-extrabold text-gray-300 text-6xl p-2 bg-gray-500 bg-opacity-50 cursor-pointer" x-on:click="nextSlide()"><i class="fa-solid fa-caret-right"></i></div>
</div>