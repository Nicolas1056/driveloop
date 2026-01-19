<x-page>
    @if(session('success'))
        <div class="p-4 mb-6 text-green-700 bg-green-100 rounded-lg">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="p-4 mb-6 text-red-700 bg-red-100 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Tarjeta Documento de Identidad -->
        <x-card class="p-6 bg-white shadow-lg">
            <div class="border-b border-gray-100 pb-4 mb-6">
                <h5 class="text-xl font-semibold text-dl">Documento de Identidad</h5>
                <p class="text-sm text-gray-500 mt-1">Sube una foto clara de tu Cédula o Pasaporte.</p>
            </div>
            @if($docIdentidad)
                <div
                    class="mb-4 p-4 rounded-md {{ $docIdentidad->estado == 'APROBADO' ? 'bg-green-50 text-green-700' : ($docIdentidad->estado == 'RECHAZADO' ? 'bg-red-50 text-red-700' : 'bg-blue-50 text-blue-700') }}">
                    <div class="font-bold">Estado: {{ $docIdentidad->estado }}</div>
                    @if($docIdentidad->estado == 'RECHAZADO')
                        <p class="text-sm mt-1">{{ $docIdentidad->mensaje_rechazo }}</p>
                    @endif
                </div>
                <div class="mb-6">
                    <a href="{{ asset('storage/' . $docIdentidad->url_archivo) }}" target="_blank"
                        class="text-dl hover:underline text-sm font-medium">
                        📄 Ver archivo subido
                    </a>
                </div>
            @else
                <div class="mb-6 p-3 bg-yellow-50 text-yellow-700 rounded-md text-sm">
                    ⚠️ No has subido este documento.
                </div>
            @endif
            @if(!$docIdentidad || $docIdentidad->estado == 'RECHAZADO')
                <form action="{{ route('usuario.documentos.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf
                    <!-- Selector de Tipo de Documento -->
                    <div class="relative mb-4">
                        <div class="absolute left-2 top-[15px] -translate-y-1/2 text-xs w-[96%] h-7 pointer-events-none">
                            <label
                                class="absolute left-2 top-[6px] text-xs font-medium text-gray-400 tracking-wider whitespace-nowrap">
                                Tipo de Documento
                            </label>
                        </div>
                        <select name="documento_tipo"
                            class="w-full px-4 pt-7 pb-2 text-sm border border-dl xl:rounded-md bg-white appearance-none cursor-pointer focus:outline-none focus:ring-1 focus:ring-dl"
                            required>
                            <option value="">Seleccione un tipo de documento</option>
                            @foreach ($documentosTipo as $tipo)
                                <option value="{{ $tipo->id }}">{{ $tipo->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <x-input type="text" name="num" label="Número de Documento" placeholder="Ej: 123456789" required />
                    <x-input type="file" name="archivo" label="Foto del Documento" required />
                    <div class="pt-2">
                        <x-button type="primary" class="w-full">
                            Subir Identidad
                        </x-button>
                    </div>
                </form>
            @endif
        </x-card>
        <!-- Tarjeta Licencia de Conducción -->
        <x-card class="p-6 bg-white shadow-lg">
            <div class="border-b border-gray-100 pb-4 mb-6">
                <h5 class="text-xl font-semibold text-dl">Licencia de Conducción</h5>
                <p class="text-sm text-gray-500 mt-1">Sube una foto de tu licencia vigente.</p>
            </div>
            @if($docLicencia)
                <div
                    class="mb-4 p-4 rounded-md {{ $docLicencia->estado == 'APROBADO' ? 'bg-green-50 text-green-700' : ($docLicencia->estado == 'RECHAZADO' ? 'bg-red-50 text-red-700' : 'bg-blue-50 text-blue-700') }}">
                    <div class="font-bold">Estado: {{ $docLicencia->estado }}</div>
                    @if($docLicencia->estado == 'RECHAZADO')
                        <p class="text-sm mt-1">{{ $docLicencia->mensaje_rechazo }}</p>
                    @endif
                </div>
                <div class="mb-6">
                    <a href="{{ asset('storage/' . $docLicencia->url_archivo) }}" target="_blank"
                        class="text-dl hover:underline text-sm font-medium">
                        📄 Ver archivo subido
                    </a>
                </div>
            @else
                <div class="mb-6 p-3 bg-yellow-50 text-yellow-700 rounded-md text-sm">
                    ⚠️ No has subido este documento.
                </div>
            @endif
            @if(!$docLicencia || $docLicencia->estado == 'RECHAZADO')
                <form action="{{ route('usuario.documentos.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf
                    <input type="hidden" name="documento_tipo" value="2">
                    <x-input type="text" name="num" label="Número de Licencia" placeholder="Ej: LIC-987654" required />
                    <x-input type="file" name="archivo" label="Foto de Licencia" required />
                    <div class="pt-20">
                        <x-button type="primary" class="w-full">
                            Subir Licencia
                        </x-button>
                    </div>
                </form>
            @endif
        </x-card>
    </div>
</x-page>