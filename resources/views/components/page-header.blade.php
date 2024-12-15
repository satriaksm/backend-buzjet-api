<div class="flex flex-col md:flex-row text-center justify-between mb-4">
    <h2 class="mb-4 text-3xl font-extrabold leading-none tracking-tight text-gray-900 md:text-4xl dark:text-white capitalize">{{$title}}</h2>
    @if($buttonAvailable)
        <a href="{{route($title.'.create')}}"
            class="flex justify-center items-center focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-1 me-2 dark:focus:ring-yellow-900">{{$buttonText}}</a>
    @endif
</div>
