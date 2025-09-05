<div id="create-ustadz-modal" class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto">
    <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-5xl sm:w-full m-3 sm:mx-auto">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-900 dark:border-neutral-700">
            <div class="p-4 overflow-y-auto max-h-[90vh]">
                <div class="flex justify-between items-center py-3 px-4 border-b dark:border-neutral-700">
                    <h3 class="font-bold text-gray-800 dark:text-white">Tambah Data Ustadz</h3>
                    <button type="button" class="flex justify-center items-center size-7 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700" data-hs-overlay="#create-ustadz-modal">
                        <span class="sr-only">Close</span>
                        <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m18 6-12 12"/>
                            <path d="m6 6 12 12"/>
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('ustadz.store') }}" enctype="multipart/form-data" class="p-4">
                    @csrf
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Left Column - Personal Data -->
                        <div class="space-y-6">
                            <div class="border-b border-gray-200 dark:border-neutral-700 pb-4">
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Data Pribadi</h4>
                            </div>

                            <!-- NIP -->
                            <div>
                                <label class="block text-sm font-medium mb-2 dark:text-white">NIP *</label>
                                <input type="text" name="nip" required
                                       class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                       placeholder="Masukkan NIP">
                            </div>

                            <!-- Nama Lengkap -->
                            <div>
                                <label class="block text-sm font-medium mb-2 dark:text-white">Nama Lengkap *</label>
                                <input type="text" name="full_name" required
                                       class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                       placeholder="Masukkan nama lengkap">
                            </div>

                            <!-- Jenis Kelamin -->
                            <div>
                                <label class="block text-sm font-medium mb-2 dark:text-white">Jenis Kelamin *</label>
                                <select name="gender" required class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:ring-neutral-600">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>

                            <!-- Tanggal Lahir -->
                            <div>
                                <label class="block text-sm font-medium mb-2 dark:text-white">Tanggal Lahir *</label>
                                <input type="date" name="birth_date" required
                                       class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:ring-neutral-600">
                            </div>

                            <!-- Tempat Lahir -->
                            <div>
                                <label class="block text-sm font-medium mb-2 dark:text-white">Tempat Lahir *</label>
                                <input type="text" name="birth_place" required
                                       class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                       placeholder="Masukkan tempat lahir">
                            </div>

                            <!-- Alamat -->
                            <div>
                                <label class="block text-sm font-medium mb-2 dark:text-white">Alamat *</label>
                                <textarea name="address" required rows="3"
                                          class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                          placeholder="Masukkan alamat lengkap"></textarea>
                            </div>

                            <!-- Phone & Email -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium mb-2 dark:text-white">No. HP *</label>
                                    <input type="text" name="phone" required
                                           class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                           placeholder="081234567890">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-2 dark:text-white">Email *</label>
                                    <input type="email" name="email" required
                                           class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                           placeholder="email@example.com">
                                </div>
                            </div>

                            <!-- Foto -->
                            <div>
                                <label class="block text-sm font-medium mb-2 dark:text-white">Foto</label>
                                <input type="file" name="photo" accept="image/*"
                                       class="block w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 file:bg-gray-50 file:border-0 file:me-4 file:py-3 file:px-4 dark:file:bg-neutral-700 dark:file:text-neutral-400">
                            </div>
                        </div>

                        <!-- Right Column - Academic & Employment Data -->
                        <div class="space-y-6">
                            <div class="border-b border-gray-200 dark:border-neutral-700 pb-4">
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Data Akademik & Kepegawaian</h4>
                            </div>

                            <!-- Education Level -->
                            <div>
                                <label class="block text-sm font-medium mb-2 dark:text-white">Tingkat Pendidikan *</label>
                                <select name="education_level" required class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:ring-neutral-600">
                                    <option value="">Pilih Tingkat Pendidikan</option>
                                    <option value="SMA">SMA/Sederajat</option>
                                    <option value="D3">D3</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                </select>
                            </div>

                            <!-- Education Major -->
                            <div>
                                <label class="block text-sm font-medium mb-2 dark:text-white">Jurusan/Bidang Studi</label>
                                <input type="text" name="education_major"
                                       class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                       placeholder="Pendidikan Agama Islam">
                            </div>

                            <!-- Certification -->
                            <div>
                                <label class="block text-sm font-medium mb-2 dark:text-white">Sertifikat/Keahlian</label>
                                <input type="text" name="certification"
                                       class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                       placeholder="Sertifikat Tahfidz, Qiroah, dll">
                            </div>

                            <!-- Join Date -->
                            <div>
                                <label class="block text-sm font-medium mb-2 dark:text-white">Tanggal Bergabung *</label>
                                <input type="date" name="join_date" required value="{{ date('Y-m-d') }}"
                                       class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:ring-neutral-600">
                            </div>

                            <!-- Employment Status -->
                            <div>
                                <label class="block text-sm font-medium mb-2 dark:text-white">Status Kepegawaian *</label>
                                <select name="employment_status" required class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:ring-neutral-600">
                                    <option value="">Pilih Status</option>
                                    <option value="tetap">Tetap</option>
                                    <option value="honorer">Honorer</option>
                                    <option value="magang">Magang</option>
                                </select>
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-medium mb-2 dark:text-white">Status *</label>
                                <select name="status" required class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:ring-neutral-600">
                                    <option value="active">Aktif</option>
                                    <option value="inactive">Tidak Aktif</option>
                                </select>
                            </div>

                            <!-- User Role -->
                            <div>
                                <label class="block text-sm font-medium mb-2 dark:text-white">Hak Akses Sistem *</label>
                                <select name="user_role" required class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:ring-neutral-600">
                                    <option value="">Pilih Hak Akses</option>
                                    <option value="admin">Administrator</option>
                                    <option value="ustadz">Ustadz/Ustadzah</option>
                                    <option value="pengurus">Pengurus</option>
                                </select>
                            </div>

                            <!-- Password -->
                            <div>
                                <label class="block text-sm font-medium mb-2 dark:text-white">Password *</label>
                                <input type="password" name="password" required
                                       class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                       placeholder="Minimal 6 karakter">
                            </div>

                            <!-- Roles -->
                            <div>
                                <label class="block text-sm font-medium mb-2 dark:text-white">Peran di TPA</label>
                                <div class="space-y-2">
                                    @foreach($roles as $role)
                                        <div class="flex items-center">
                                            <input type="checkbox" name="roles[]" value="{{ $role->id }}" 
                                                   class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-neutral-600 dark:bg-neutral-800 dark:focus:ring-blue-500">
                                            <label class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                                {{ $role->display_name }}
                                                @if($role->description)
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">({{ $role->description }})</span>
                                                @endif
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t dark:border-neutral-700 mt-6">
                        <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800" data-hs-overlay="#create-ustadz-modal">
                            Batal
                        </button>
                        <button type="submit" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>