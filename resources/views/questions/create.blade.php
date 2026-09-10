<x-app-layout>
    <x-slot name="title">
        Input Pertanyaan
    </x-slot>

    <div class="py-4 md:py-6"> 
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                <div class="p-4 md:p-6 bg-white border-b border-gray-200"> 
                    {{-- Header Form --}}
                    <div class="flex items-center gap-2 mb-6 border-b pb-3">
                        <div class="w-1.5 h-6 bg-indigo-600 rounded-full"></div>
                        <h1 class="text-lg font-bold text-gray-800 tracking-tight">Form Input Pertanyaan</h1>
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

                    <form action="{{ route('questions.store') }}" method="POST" class="mt-2"> 
                        @csrf

                    {{-- Kotak Tempel Chat WhatsApp --}}
                    <div class="mb-6 p-4 bg-indigo-50 border border-indigo-100 rounded-xl">
                        <label class="block text-[10px] font-black text-indigo-600 uppercase tracking-widest mb-2">
                            Tempel Chat WhatsApp Warga (Opsional)
                        </label>
                        <textarea id="waste_paste" rows="6" placeholder="Salin (copy) balasan template dari warga di WhatsApp, lalu paste (tempel) di sini..." class="block w-full rounded-xl border-indigo-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2.5"></textarea>
                        <button type="button" id="btn_auto_fill" class="mt-3 inline-flex items-center px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold uppercase tracking-widest rounded-xl transition active:scale-95">
                            Isi Otomatis dari Chat
                        </button>
                        <p id="auto_fill_status" class="mt-2 text-xs font-semibold"></p>
                    </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4"> 
                            {{-- Baris 1: Tanggal & NIK --}}
                            <div class="space-y-1">
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest">Tanggal</label>
                                <input type="date" name="tanggal" value="{{ old('tanggal') }}" class="block w-full rounded-xl border-gray-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2.5 md:py-2" required>
                                @error('tanggal')<p class="text-[10px] text-red-600 font-bold">{{ $message }}</p>@enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest">NIK (16 Digit)</label>
                                <input type="number" name="nik" value="{{ old('nik') }}" placeholder="Contoh: 327101..." class="block w-full rounded-xl border-gray-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2.5 md:py-2" required>
                                @error('nik')<p class="text-[10px] text-red-600 font-bold">{{ $message }}</p>@enderror
                            </div>

                            {{-- Baris 2: Nama & No HP --}}
                            <div class="space-y-1">
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest">Nama Lengkap</label>
                                <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama sesuai KTP" class="block w-full rounded-xl border-gray-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2.5 md:py-2" required>
                                @error('nama')<p class="text-[10px] text-red-600 font-bold">{{ $message }}</p>@enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest">No WhatsApp / HP</label>
                                <input type="tel" name="no_hp" value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx" class="block w-full rounded-xl border-gray-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2.5 md:py-2" required>
                                @error('no_hp')<p class="text-[10px] text-red-600 font-bold">{{ $message }}</p>@enderror
                            </div>

                            {{-- Baris 3: Jenis Kelamin & Kecamatan --}}
                            <div class="space-y-1">
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="block w-full rounded-xl border-gray-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2.5 md:py-2" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin')=='Laki-laki' ? 'selected':'' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin')=='Perempuan' ? 'selected':'' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')<p class="text-[10px] text-red-600 font-bold">{{ $message }}</p>@enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest">Kecamatan</label>
                                <select name="kecamatan" id="kecamatan_select" class="block w-full rounded-xl border-gray-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2.5 md:py-2">
                                    <option value="">-- Pilih Kecamatan --</option>
                                </select>
                                @error('kecamatan')<p class="text-[10px] text-red-600 font-bold">{{ $message }}</p>@enderror
                            </div>

                            {{-- Baris 4: Kelurahan & Jenis Layanan --}}
                            <div class="space-y-1">
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest">Kelurahan</label>
                                <select name="kelurahan" id="kelurahan_select" class="block w-full rounded-xl border-gray-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2.5 md:py-2">
                                    <option value="">-- Pilih Kelurahan --</option>
                                </select>
                                @error('kelurahan')<p class="text-[10px] text-red-600 font-bold">{{ $message }}</p>@enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest">Kategori Layanan</label>
                                <select name="jenis_layanan" class="block w-full rounded-xl border-gray-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2.5 md:py-2">
                                    <option value="">-- Pilih --</option>
                                    @forelse($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('jenis_layanan') == $cat->id ? 'selected' : '' }}>{{ $cat->name ?? $cat->nama }}</option>
                                    @empty
                                        <option value="">(Belum ada kategori)</option>
                                    @endforelse
                                </select>
                                @error('jenis_layanan')<p class="text-[10px] text-red-600 font-bold">{{ $message }}</p>@enderror
                            </div>

                            {{-- Textarea Detail --}}
                            <div class="md:col-span-2 space-y-1">
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest">Detail Pertanyaan / Catatan</label>
                                <textarea name="detail" rows="4" placeholder="Tuliskan isi pertanyaan masyarakat secara detail..." class="block w-full rounded-xl border-gray-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2.5 md:py-2">{{ old('detail') }}</textarea>
                                @error('detail')<p class="text-[10px] text-red-600 font-bold">{{ $message }}</p>@enderror
                            </div>

                            {{-- Jam Masuk & Balas --}}
                            <div class="space-y-1">
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest">Jam Masuk Chat</label>
                                <input id="jam_masuk" type="time" name="jam_masuk" value="{{ old('jam_masuk') }}" max="16:00" class="block w-full rounded-xl border-gray-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2.5 md:py-2">
                                @error('jam_masuk')<p class="text-[10px] text-red-600 font-bold">{{ $message }}</p>@enderror
                            </div>

                            <div class="space-y-1">
                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest">Jam Dibalas</label>
                                <input id="jam_di_balasan" type="time" name="jam_di_balasan" value="{{ old('jam_di_balasan') }}" max="16:00" class="block w-full rounded-xl border-gray-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm py-2.5 md:py-2">
                                @error('jam_di_balasan')<p class="text-[10px] text-red-600 font-bold">{{ $message }}</p>@enderror
                            </div>

                            {{-- Footer Buttons --}}
                            <div class="md:col-span-2 flex flex-col md:flex-row items-center gap-4 mt-6 pt-6 border-t border-gray-100">
                                <button type="submit" class="w-full md:w-auto inline-flex items-center justify-center px-8 py-3 bg-indigo-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:scale-95 transition-all shadow-lg shadow-indigo-100">
                                    Simpan Pertanyaan
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
            Object.keys(kelurahansMap).forEach(function(kec) {
                const opt = document.createElement('option');
                opt.value = kec;
                opt.textContent = kec;
                kecSelect.appendChild(opt);
            });

            const oldKec = '{{ old('kecamatan') }}';
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
            list.forEach(function(kel) {
                const opt = document.createElement('option');
                opt.value = kel;
                opt.textContent = kel;
                kelSelect.appendChild(opt);
            });

            const oldKel = '{{ old('kelurahan') }}';
            if (oldKel) {
                kelSelect.value = oldKel;
            }
        }

        // ===== Logic Parsing & Auto-fill dari Chat WhatsApp =====
        function normalizeGenderJS(raw) {
            raw = raw.toLowerCase().trim().replace(/\s+/g, ' ').replace(/-/g, ' ');
            const lakiVariasi = ['l', 'lk', 'laki', 'laki laki', 'pria', 'cowok', 'cowo'];
            const perempuanVariasi = ['p', 'pr', 'perempuan', 'wanita', 'cewek', 'cewe'];
            if (lakiVariasi.includes(raw)) return 'Laki-laki';
            if (perempuanVariasi.includes(raw)) return 'Perempuan';
            return raw;
        }

        function parseWaTemplate(text) {
            const lines = text.split('\n');
            const validKeys = ['nama', 'nik', 'no hp', 'no hpwhatsapp', 'jenis kelamin', 'kecamatan', 'kelurahan', 'layanan', 'keluhan'];
            const result = {};

            lines.forEach(function(line) {
                if (line.includes(':')) {
                    const idx = line.indexOf(':');
                    let key = line.substring(0, idx).toLowerCase().trim();
                    key = key.replace(/[^a-z ]/g, '');
                    const value = line.substring(idx + 1).trim();

                    if (validKeys.includes(key) && !(key in result)) {
                        result[key] = value;
                    }
                }
            });

            return result;
        }

        function findMatchingOption(selectEl, searchText) {
            if (!searchText) return null;
            const search = searchText.toLowerCase();
            const options = Array.from(selectEl.options);
            const found = options.find(opt => opt.value && opt.value.toLowerCase() === search);
            if (found) return found.value;
            const partial = options.find(opt => opt.value && (
                search.includes(opt.value.toLowerCase()) || opt.value.toLowerCase().includes(search)
            ));
            return partial ? partial.value : null;
        }

        function findMatchingCategoryOption(selectEl, searchText) {
            if (!searchText) return null;
            const search = searchText.toLowerCase();
            const options = Array.from(selectEl.options);
            const found = options.find(opt => opt.textContent && search.includes(opt.textContent.trim().toLowerCase()));
            return found ? found.value : null;
        }

        document.getElementById('btn_auto_fill').addEventListener('click', function() {
            const text = document.getElementById('waste_paste').value;
            const statusEl = document.getElementById('auto_fill_status');

            if (!text.trim()) {
                statusEl.textContent = 'Kotak chat masih kosong.';
                statusEl.className = 'mt-2 text-xs font-semibold text-rose-600';
                return;
            }

            const data = parseWaTemplate(text);
            let filledCount = 0;

            if (data['nama']) {
                document.querySelector('[name="nama"]').value = data['nama'];
                filledCount++;
            }
            if (data['nik']) {
                document.querySelector('[name="nik"]').value = data['nik'].replace(/[^0-9]/g, '');
                filledCount++;
            }
                        if (data['no hp'] || data['no hpwhatsapp']) {
                const noHpValue = data['no hp'] || data['no hpwhatsapp'];
                document.querySelector('[name="no_hp"]').value = noHpValue.replace(/[^0-9]/g, '');
                filledCount++;
            }
            if (data['jenis kelamin']) {
                document.querySelector('[name="jenis_kelamin"]').value = normalizeGenderJS(data['jenis kelamin']);
                filledCount++;
            }
            if (data['kecamatan']) {
                const match = findMatchingOption(kecSelect, data['kecamatan']);
                if (match) {
                    kecSelect.value = match;
                    populateKelurahan(match);
                    filledCount++;

                    if (data['kelurahan']) {
                        const kelMatch = findMatchingOption(kelSelect, data['kelurahan']);
                        if (kelMatch) {
                            kelSelect.value = kelMatch;
                            filledCount++;
                        }
                    }
                }
            }
            if (data['layanan']) {
                const layananSelect = document.querySelector('[name="jenis_layanan"]');
                const match = findMatchingCategoryOption(layananSelect, data['layanan']);
                if (match) {
                    layananSelect.value = match;
                    filledCount++;
                }
            }
            if (data['keluhan']) {
                document.querySelector('[name="detail"]').value = data['keluhan'];
                filledCount++;
            }

            // Isi tanggal & jam masuk otomatis kalau masih kosong
            const tanggalInput = document.querySelector('[name="tanggal"]');
            if (!tanggalInput.value) {
                tanggalInput.value = new Date().toISOString().split('T')[0];
            }
            if (jamMasuk && !jamMasuk.value) {
                const now = new Date();
                jamMasuk.value = String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0');
            }

            statusEl.textContent = filledCount + ' field berhasil diisi otomatis. Silakan periksa sebelum menyimpan.';
            statusEl.className = 'mt-2 text-xs font-semibold text-emerald-600';
        });

        document.addEventListener('DOMContentLoaded', function() {
            populateKecamatan();
            kecSelect.addEventListener('change', function() {
                populateKelurahan(this.value);
            });

            const jamMasuk = document.getElementById('jam_masuk');
            const jamBalasan = document.getElementById('jam_di_balasan');
            const MAX_TIME = '16:00';

            function clampToMax(el) {
                if (!el) return;
                el.setAttribute('max', MAX_TIME);
                if (el.value && el.value > MAX_TIME) el.value = MAX_TIME;
            }

            function applyMinAndFix() {
                if (!jamBalasan) return;
                clampToMax(jamMasuk);
                clampToMax(jamBalasan);

                if (!jamMasuk || !jamMasuk.value) {
                    jamBalasan.removeAttribute('min');
                    return;
                }

                const min = jamMasuk.value;
                jamBalasan.setAttribute('min', min);
                if (!jamBalasan.value || jamBalasan.value < min) jamBalasan.value = min;
            }

            if (jamBalasan) {
                jamBalasan.addEventListener('focus', function() {
                    if (jamMasuk && jamMasuk.value && (!this.value || this.value < jamMasuk.value)) {
                        this.value = jamMasuk.value;
                    }
                });
            }

            if (jamMasuk) jamMasuk.addEventListener('change', applyMinAndFix);
            applyMinAndFix();
        });
    </script>
    @endpush
</x-app-layout>