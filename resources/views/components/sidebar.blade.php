<aside class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidenav" id="drawer-navigation">
    <div class="overflow-y-auto py-5 px-3 h-full bg-white dark:bg-gray-800">
        <form action="#" method="GET" class="md:hidden mb-2">
            <label for="sidebar-search" class="sr-only">Search</label>
            <div class="relative">
                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"></path>
                    </svg>
                </div>
                <input type="text" name="search" id="sidebar-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Search" />
            </div>
        </form>
        <ul class="space-y-2">
            <li class="{{ Request::is('dashboard') ? 'mx-2 bg-blue-500 rounded-xl text-white' : 'mx-2 hover:bg-blue-500 hover:rounded-xl hover:text-white' }}">
                <a href="/dashboard" class="flex items-center p-2 text-base font-medium {{ Request::is('dashboard') ? 'text-inherit' : 'text-gray-900 dark:text-white' }} group">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-house me-2" >
                        <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"/>
                        <path d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    </svg>
                    Dashboard
                </a>
            </li>
            <li class="{{ Request::is('destinations') ? 'mx-2 bg-blue-500 rounded-xl text-white' : 'mx-2 hover:bg-blue-500 hover:rounded-xl hover:text-white' }}">
                <a href="/destinations" class="flex items-center p-2 text-base font-medium {{ Request::is('destinations') ? 'text-inherit' : 'text-gray-900 dark:text-white' }} group">
                    <svg class='me-2' xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="24" height="24" viewBox="0 0 24 24" style="{{ Request::is('destinations') ? 'fill: rgba(255, 255, 255, 1);transform: ;msFilter:;' : ';transform: ;msFilter:;' }}">
                        <path d="M19 2H9c-1.103 0-2 .897-2 2v6H5c-1.103 0-2 .897-2 2v9a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V4c0-1.103-.897-2-2-2zM5 12h6v8H5v-8zm14 8h-6v-8c0-1.103-.897-2-2-2H9V4h10v16z"></path>
                        <path d="M11 6h2v2h-2zm4 0h2v2h-2zm0 4.031h2V12h-2zM15 14h2v2h-2zm-8 .001h2v2H7z"></path>
                    </svg>
                    Destinasi
                </a>
            </li>
            <li class="{{ Request::is('transportations') ? 'mx-2 bg-blue-500 rounded-xl text-white' : 'mx-2 hover:bg-blue-500 hover:rounded-xl hover:text-white' }}">
                <a href="/transportations" class="flex items-center p-2 text-base font-medium {{ Request::is('transportations') ? 'text-inherit' : 'text-gray-900 dark:text-white' }} group">
                    <svg class="me-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="{{ Request::is('transportations') ? 'fill: rgba(255, 255, 255, 1);transform: ;msFilter:;' : ';transform: ;msFilter:;' }}">
                        <path d="m20.772 10.156-1.368-4.105A2.995 2.995 0 0 0 16.559 4H7.441a2.995 2.995 0 0 0-2.845 2.051l-1.368 4.105A2.003 2.003 0 0 0 2 12v5c0 .753.423 1.402 1.039 1.743-.013.066-.039.126-.039.195V21a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-2h12v2a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-2.062c0-.069-.026-.13-.039-.195A1.993 1.993 0 0 0 22 17v-5c0-.829-.508-1.541-1.228-1.844zM4 17v-5h16l.002 5H4zM7.441 6h9.117c.431 0 .813.274.949.684L18.613 10H5.387l1.105-3.316A1 1 0 0 1 7.441 6z"></path>
                        <circle cx="6.5" cy="14.5" r="1.5"></circle>
                        <circle cx="17.5" cy="14.5" r="1.5"></circle>
                    </svg>
                    Transportasi
                </a>
            </li>
            <li class="{{ Request::is('hotels') ? 'mx-2 bg-blue-500 rounded-xl text-white' : 'mx-2 hover:bg-blue-500 hover:rounded-xl hover:text-white' }}">
                <a href="/hotels" class="flex items-center p-2 text-base font-medium {{ Request::is('hotels') ? 'text-inherit' : 'text-gray-900 dark:text-white' }} group">
                    <svg class="me-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="{{ Request::is('hotels') ? 'fill: rgba(255, 255, 255, 1);transform: ;msFilter:;' : ';transform: ;msFilter:;' }}">
                        <circle cx="7.5" cy="11.5" r="2.5"></circle>
                        <path d="M17.205 7H12a1 1 0 0 0-1 1v7H4V6H2v14h2v-3h16v3h2v-8.205A4.8 4.8 0 0 0 17.205 7zM13 15V9h4.205A2.798 2.798 0 0 1 20 11.795V15h-7z"></path>
                    </svg>
                    Hotel
                </a>
            </li>
            <li class="{{ Request::is('locations') ? 'mx-2 bg-blue-500 rounded-xl text-white' : 'mx-2 hover:bg-blue-500 hover:rounded-xl hover:text-white' }}">
                <a href="/locations" class="flex items-center p-2 text-base font-medium {{ Request::is('locations') ? 'text-inherit' : 'text-gray-900 dark:text-white' }} group">
                    <svg class="me-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 384 512">
                        <path d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"/>
                    </svg>
                    Lokasi
                </a>
            </li>
            <li class="{{ Request::is('packages') ? 'mx-2 bg-blue-500 rounded-xl text-white' : 'mx-2 hover:bg-blue-500 hover:rounded-xl hover:text-white' }}">
                <a href="/packages" class="flex items-center p-2 text-base font-medium {{ Request::is('packages') ? 'text-inherit' : 'text-gray-900 dark:text-white' }} group">
                    <svg class="me-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="{{ Request::is('packages') ? 'fill: rgba(255, 255, 255, 1);transform: ;msFilter:;' : ';transform: ;msFilter:;' }}">
                        <path d="M22 8a.76.76 0 0 0 0-.21v-.08a.77.77 0 0 0-.07-.16.35.35 0 0 0-.05-.08l-.1-.13-.08-.06-.12-.09-9-5a1 1 0 0 0-1 0l-9 5-.09.07-.11.08a.41.41 0 0 0-.07.11.39.39 0 0 0-.08.1.59.59 0 0 0-.06.14.3.3 0 0 0 0 .1A.76.76 0 0 0 2 8v8a1 1 0 0 0 .52.87l9 5a.75.75 0 0 0 .13.06h.1a1.06 1.06 0 0 0 .5 0h.1l.14-.06 9-5A1 1 0 0 0 22 16V8zm-10 3.87L5.06 8l2.76-1.52 6.83 3.9zm0-7.72L18.94 8 16.7 9.25 9.87 5.34zM4 9.7l7 3.92v5.68l-7-3.89zm9 9.6v-5.68l3-1.68V15l2-1v-3.18l2-1.11v5.7z"></path>
                    </svg>
                    Paket
                </a>
            </li>
            <hr>
            <li class="{{ Request::is('bookings') ? 'mx-2 bg-blue-500 rounded-xl text-white' : 'mx-2 hover:bg-blue-500 hover:rounded-xl hover:text-white' }}">
                <a href="/bookings" class="flex items-center p-2 text-base font-medium {{ Request::is('bookings') ? 'text-inherit' : 'text-gray-900 dark:text-white' }} group">
                    <svg class="me-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512">
                        <path d="M160 96a96 96 0 1 1 192 0A96 96 0 1 1 160 96zm80 152l0 264-48.4-24.2c-20.9-10.4-43.5-17-66.8-19.3l-96-9.6C12.5 457.2 0 443.5 0 427L0 224c0-17.7 14.3-32 32-32l30.3 0c63.6 0 125.6 19.6 177.7 56zm32 264l0-264c52.1-36.4 114.1-56 177.7-56l30.3 0c17.7 0 32 14.3 32 32l0 203c0 16.4-12.5 30.2-28.8 31.8l-96 9.6c-23.2 2.3-45.9 8.9-66.8 19.3L272 512z"/>
                    </svg>
                    Booking
                </a>
            </li>
        </ul>
    </div>
</aside>

