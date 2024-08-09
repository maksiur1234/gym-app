<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Lista trenerów:</h3>
                    <ul>
                        @foreach ($data as $trainer)
                            <li>{{ $trainer['name'] }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
    </div>