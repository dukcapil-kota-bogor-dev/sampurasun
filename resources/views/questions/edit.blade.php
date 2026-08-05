<x-app-layout>
    <x-slot name="title">
        Ubah Pertanyaan
    </x-slot>

    <div class="py-4 md:py-6">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                <div class="p-4 md:p-6 bg-white border-b border-gray-200">
                    
                    {{-- Header Form --}}
                    <div class="flex items-center gap-2 mb-6 border-b pb-3">
                        <div class="w-1.5 h-6 bg-indigo-600 rounded-full"></div>
                        <h1 class="text-lg font-bold text-gray-800 tracking-tight">Form Ubah Pertanyaan</h1>
                    </div>

                    {{-- Alert Status --}}
                    @if(session('status'))
                        <div class="mb-4 p-4 bg-emerald-50 border-l-4 border-emerald-400 text-emerald-800 rounded-r-lg text-sm font-bold shadow-sm">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- Alert Error --}}
                    @if($errors->any())
                        <div class="mb-4 p-4 bg-rose-50 border-l-4 border-rose-400 text-rose-800 rounded-r-lg text-sm">
                            <p class="font-bold mb-1 uppercase tracking-wider text-xs text-rose-900">Periksa kembali inputan Anda:</p>
                            <ul class="list-disc pl-5 space-y-0.5 font-medium">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('questions.update', $question->id) }}" method="POST" class="mt-2">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                            
                            {{-- Field: Tanggal --}}
                            <div class="space-y-1">
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest">Tanggal</label>
                                <input type="date" name="tanggal" value="{{ old('tanggal', $question->tanggal) }}" class="block w-full rounded-xl border-gray-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2.5 md:py-2" required>
                                @error('tanggal')<p class="text-[10px] text-red-600 font-bold">{{ $message }}</p>@enderror
                            </div>

                            {{-- Field: NIK --}}
                            <div class="space-y-1">
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest">NIK</label>
                                <input type="text" name="nik" value="{{ old('nik', $question->nik) }}" placeholder="16 Digit NIK" class="block w-full rounded-xl border-gray-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2.5 md:py-2" required>
                                @error('nik')<p class="text-[10px] text-red-600 font-bold">{{ $message }}</p>@enderror
                            </div>

                            {{-- Field: Nama --}}
                            <div class="space-y-1">
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest">Nama Lengkap</label>
                                <input type="text" name="nama" value="{{ old('nama', $question->nama) }}" class="block w-full rounded-xl border-gray-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2.5 md:py-2" required>
                                @error('nama')<p class="text-[10px] text-red-600 font-bold">{{ $message }}</p>@enderror
                            </div>

                            {{-- Field: No HP --}}
                            <div class="space-y-1">
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest">No HP / WhatsApp</label>
                                <input type="text" name="no_hp" value="{{ old('no_hp', $question->no_hp) }}" placeholder="08xxxxxxxxxx" class="block w-full rounded-xl border-gray-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2.5 md:py-2" required>
                                @error('no_hp')<p class="text-[10px] text-red-600 font-bold">{{ $message }}</p>@enderror
                            </div>

                            {{-- Field: Jenis Kelamin --}}
                            <div class="space-y-1">
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="block w-full rounded-xl border-gray-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2.5 md:py-2" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin', $question->jenis_kelamin)=='Laki-laki' ? 'selected':'' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin', $question->jenis_kelamin)=='Perempuan' ? 'selected':'' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')<p class="text-[10px] text-red-600 font-bold">{{ $message }}</p>@enderror
                            </div>

                            {{-- Field: Kecamatan --}}
                            <div class="space-y-1">
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest">Kecamatan</label>
                                <select name="kecamatan" id="kecamatan_select" class="block w-full rounded-xl border-gray-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2.5 md:py-2">
                                    <option value="">-- Pilih Kecamatan --</option>
                                </select>
                                @error('kecamatan')<p class="text-[10px] text-red-600 font-bold">{{ $message }}</p>@enderror
                            </div>

                            {{-- Field: Kelurahan --}}
                            <div class="space-y-1">
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest">Kelurahan</label>
                                <select name="kelurahan" id="kelurahan_select" class="block w-full rounded-xl border-gray-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2.5 md:py-2">
                                    <option value="">-- Pilih Kelurahan --</option>
                                </select>
                                @error('kelurahan')<p class="text-[10px] text-red-600 font-bold">{{ $message }}</p>@enderror
                            </div>

                            {{-- Field: Jenis Layanan --}}
                            <div class="space-y-1">
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest">Jenis Layanan</label>
                                <select name="jenis_layanan" class="block w-full rounded-xl border-gray-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2.5 md:py-2">
                                    <option value="">-- Pilih --</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('jenis_layanan', $question->jenis_layanan_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name ?? $cat->nama ?? 'Kategori '.$cat->id }}</option>
                                    @endforeach
                                </select>
                                @error('jenis_layanan')<p class="text-[10px] text-red-600 font-bold">{{ $message }}</p>@enderror
                            </div>

                            {{-- Field: Detail (Full Width) --}}
                            <div class="md:col-span-2 space-y-1">
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest">Detail Pertanyaan</label>
                                <textarea name="detail" rows="4" class="block w-full rounded-xl border-gray-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2.5 md:py-2">{{ old('detail', $question->detail) }}</textarea>
                                @error('detail')<p class="text-[10px] text-red-600 font-bold">{{ $message }}</p>@enderror
                            </div>

                            {{-- Field: Jam Masuk --}}
                            <div class="space-y-1">
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest">Jam Masuk</label>
                                <input id="jam_masuk" type="time" name="jam_masuk" value="{{ old('jam_masuk', $question->jam_masuk) }}" max="16:00" class="block w-full rounded-xl border-gray-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2.5 md:py-2">
                                @error('jam_masuk')<p class="text-[10px] text-red-600 font-bold">{{ $message }}</p>@enderror
                            </div>

                            {{-- Field: Jam Dibalas --}}
                            <div class="space-y-1">
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest">Jam Dibalas</label>
                                <input id="jam_di_balasan" type="time" name="jam_di_balasan" value="{{ old('jam_di_balasan', $question->jam_di_balasan) }}" max="16:00" class="block w-full rounded-xl border-gray-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2.5 md:py-2">
                                @error('jam_di_balasan')<p class="text-[10px] text-red-600 font-bold">{{ $message }}</p>@enderror
                            </div>

                            {{-- Buttons --}}
                            <div class="md:col-span-2 flex flex-col md:flex-row items-center gap-3 mt-6 pt-6 border-t border-gray-100">
                                <button type="submit" class="w-full md:w-auto inline-flex items-center justify-center px-8 py-3 bg-indigo-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:scale-95 transition-all shadow-lg shadow-indigo-100">
                                    Simpan Perubahan
                                </button>
                                <a href="{{ route('questions.index') }}" class="w-full md:w-auto inline-flex items-center justify-center px-8 py-3 bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-widest rounded-xl hover:bg-gray-100 transition-all border border-gray-100 active:scale-95">
                                    Batal / Kembali
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const kelurahansMap = {
            'Bogor Utara': ['Bantarjati','Cibuluh','Ciluar','Cimahpar','Ciparigi','Kedunghalang','Tanahbaru','Tegal Gundil'],
            'Bogor Timur': ['Baranangsiang','Katulampa','Sindangrasa','Sindangsari','Sukasari','Tajur'],
            'Bogor Tengah': ['Babakan','Babakan Pasar','Cibogor','Ciwaringin','Gudang','Kebon Kelapa','Pabaton','Paledang','Panaragan','Sempur','Tegallega'],
            'Bogor Barat': ['Balumbang Jaya','Bubulak','Cilendek Barat','Cilendek Timur','Curug','Curugmekar','Gunungbatu','Loji','Margajaya','Menteng','Pasirjaya','Pasirkuda','Pasirmulya','Semplak','Sindangbarang','Situgede'],
            'Bogor Selatan': ['Batutulis','Bojongkerta','Bondongan','Cikaret','Cipaku','Empang','Genteng','Harjasari','Kertamaya','Lawanggintung','Muarasari','Mulyaharja','Pakuan','Pamoyanan','Rancamaya','Ranggamekar'],
            'Tanah Sareal': ['Tanah Sareal','Kebonpedes','Kedungbadak','Kedungjaya','Kedungwaringin','Cibadak','Kayumanis','Mekarwangi','Kencana','Sukadamai','Sukaresmi'],
            'Ludo': ['Ludo']
        };

        const kecSelect = document.getElementById('kecamatan_select');
        const kelSelect = document.getElementById('kelurahan_select');

        function populateKecamatan() {
            Object.keys(kelurahansMap).forEach(kec => {
                const opt = document.createElement('option');
                opt.value = kec;
                opt.textContent = kec;
                kecSelect.appendChild(opt);
            });

            const oldKec = "{{ old('kecamatan', $question->kecamatan) }}";
            if (oldKec) {
                kecSelect.value = oldKec;
                populateKelurahan(oldKec);
            }
        }

        function populateKelurahan(kecamatan) {
            kelSelect.innerHTML = '';
            const placeholder = document.createElement('option');
            placeholder.value = '';
            placeholder.textContent = '-- Pilih Kelurahan --';
            kelSelect.appendChild(placeholder);

            const list = kelurahansMap[kecamatan] || [];
            list.forEach(kel => {
                const opt = document.createElement('option');
                opt.value = kel;
                opt.textContent = kel;
                kelSelect.appendChild(opt);
            });

            const oldKel = "{{ old('kelurahan', $question->kelurahan) }}";
            if (oldKel) kelSelect.value = oldKel;
        }

        document.addEventListener('DOMContentLoaded', function() {
            populateKecamatan();
            kecSelect.addEventListener('change', function() { populateKelurahan(this.value); });

            const jamMasuk = document.getElementById('jam_masuk');
            const jamBalasan = document.getElementById('jam_di_balasan');
            const MAX_TIME = '16:00';

            function applyMinAndFix() {
                if (!jamBalasan) return;
                [jamMasuk, jamBalasan].forEach(el => {
                    if (el && el.value > MAX_TIME) el.value = MAX_TIME;
                });

                if (jamMasuk && jamMasuk.value) {
                    jamBalasan.setAttribute('min', jamMasuk.value);
                    if (jamBalasan.value < jamMasuk.value) jamBalasan.value = jamMasuk.value;
                }
            }

            if (jamMasuk) jamMasuk.addEventListener('change', applyMinAndFix);
            applyMinAndFix();
        });
    </script>
    @endpush
</x-app-layout>