@extends('business::layouts.master')

@section('title', 'Dropshipper Registration')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card shadow-sm border-0 mt-5">
                <div class="card-body p-5">
                    
                    <!-- Progress Bar -->
                    <div class="mb-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center">
                                <div id="step1-circle" class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <span class="fw-bold">1</span>
                                </div>
                                <div class="flex-grow-1 mx-3" style="height: 2px; background-color: #e6e6e6;"></div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div id="step2-circle" class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <span class="fw-bold">2</span>
                                </div>
                                <div class="flex-grow-1 mx-3" style="height: 2px; background-color: #e6e6e6;"></div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div id="step3-circle" class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <span class="fw-bold">3</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form id="registrationForm" method="POST" action="{{ route('business.dropshippers.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Step 1: Account Settings -->
                        <div id="step1" class="step-content">
                            <h2 class="fw-bold text-dark mb-3">Welcome to Drotop</h2>
                            <p class="text-muted mb-4">Please complete your account settings :</p>
                            
                            <div class="mb-4">
                                <label for="full_name" class="form-label d-flex align-items-center text-muted">
                                    <i class="fas fa-user me-2"></i> Full Name :
                                </label>
                                <input type="text" class="form-control form-control-lg" id="full_name" name="full_name" placeholder="Enter your full name" required>
                                @error('full_name')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-primary px-4" id="nextStep1">
                                    Next Step <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 2: Store Setup -->
                        <div id="step2" class="step-content d-none">
                            <h2 class="fw-bold text-dark mb-4">Set up your store</h2>
                            
                            <div class="mb-4">
                                <label for="store_logo" class="form-label d-flex align-items-center text-muted">
                                    <i class="fas fa-store me-2"></i> Store logo :
                                </label>
                                <div class="border rounded p-3 text-center">
                                    <input type="file" class="form-control d-none" id="store_logo" name="store_logo" accept="image/*">
                                    <label for="store_logo" class="btn btn-outline-secondary">
                                        <i class="fas fa-upload me-2"></i> Upload an Image
                                    </label>
                                    <div id="logo-preview" class="mt-2"></div>
                                </div>
                                @error('store_logo')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label for="store" class="form-label d-flex align-items-center text-muted">
                                    <i class="fas fa-store me-2"></i> Store name :
                                </label>
                                <input type="text" class="form-control form-control-lg" id="store" name="store" placeholder="Enter store name" required>
                                @error('store')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="phone" class="form-label d-flex align-items-center text-muted">
                                        <i class="fas fa-phone me-2"></i> Phone :
                                    </label>
                                    <input type="tel" class="form-control form-control-lg" id="phone" name="phone" placeholder="01-23-45-67-89" required>
                                    @error('phone')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="wilaya" class="form-label d-flex align-items-center text-muted">
                                        <i class="fas fa-map-marker-alt me-2"></i> Wilaya :
                                    </label>
                                    <select class="form-select form-select-lg" id="wilaya" name="wilaya" required>
                                        <option value="">Select a wilaya</option>
                                        <option value="01">01 - Adrar</option>
                                        <option value="02">02 - Chlef</option>
                                        <option value="03">03 - Laghouat</option>
                                        <option value="04">04 - Oum El Bouaghi</option>
                                        <option value="05">05 - Batna</option>
                                        <option value="06">06 - Béjaïa</option>
                                        <option value="07">07 - Biskra</option>
                                        <option value="08">08 - Béchar</option>
                                        <option value="09">09 - Blida</option>
                                        <option value="10">10 - Bouira</option>
                                        <option value="11">11 - Tamanrasset</option>
                                        <option value="12">12 - Tébessa</option>
                                        <option value="13">13 - Tlemcen</option>
                                        <option value="14">14 - Tiaret</option>
                                        <option value="15">15 - Tizi Ouzou</option>
                                        <option value="16">16 - Alger</option>
                                        <option value="17">17 - Djelfa</option>
                                        <option value="18">18 - Jijel</option>
                                        <option value="19">19 - Sétif</option>
                                        <option value="20">20 - Saïda</option>
                                        <option value="21">21 - Skikda</option>
                                        <option value="22">22 - Sidi Bel Abbès</option>
                                        <option value="23">23 - Annaba</option>
                                        <option value="24">24 - Guelma</option>
                                        <option value="25">25 - Constantine</option>
                                        <option value="26">26 - Médéa</option>
                                        <option value="27">27 - Mostaganem</option>
                                        <option value="28">28 - M'Sila</option>
                                        <option value="29">29 - Mascara</option>
                                        <option value="30">30 - Ouargla</option>
                                        <option value="31">31 - Oran</option>
                                        <option value="32">32 - El Bayadh</option>
                                        <option value="33">33 - Illizi</option>
                                        <option value="34">34 - Bordj Bou Arréridj</option>
                                        <option value="35">35 - Boumerdès</option>
                                        <option value="36">36 - El Tarf</option>
                                        <option value="37">37 - Tindouf</option>
                                        <option value="38">38 - Tissemsilt</option>
                                        <option value="39">39 - El Oued</option>
                                        <option value="40">40 - Khenchela</option>
                                        <option value="41">41 - Souk Ahras</option>
                                        <option value="42">42 - Tipaza</option>
                                        <option value="43">43 - Mila</option>
                                        <option value="44">44 - Aïn Defla</option>
                                        <option value="45">45 - Naâma</option>
                                        <option value="46">46 - Aïn Témouchent</option>
                                        <option value="47">47 - Ghardaïa</option>
                                        <option value="48">48 - Relizane</option>
                                        <option value="49">49 - Timimoun</option>
                                        <option value="50">50 - Bordj Badji Mokhtar</option>
                                        <option value="51">51 - Ouled Djellal</option>
                                        <option value="52">52 - Béni Abbès</option>
                                        <option value="53">53 - In Salah</option>
                                        <option value="54">54 - In Guezzam</option>
                                        <option value="55">55 - Touggourt</option>
                                        <option value="56">56 - Djanet</option>
                                        <option value="57">57 - El M'Ghair</option>
                                        <option value="58">58 - El Meniaa</option>
                                    </select>
                                    @error('wilaya')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="expires" class="form-label d-flex align-items-center text-muted">
                                    <i class="fas fa-calendar me-2"></i> Account Expires :
                                </label>
                                <input type="date" class="form-control form-control-lg" id="expires" name="expires">
                                @error('expires')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-outline-secondary px-4" id="backStep1">
                                    <i class="fas fa-arrow-left me-2"></i> Back
                                </button>
                                <button type="button" class="btn btn-primary px-4" id="nextStep2">
                                    Complete <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 3: Completion -->
                        <div id="step3" class="step-content d-none text-center">
                            <div class="mb-4">
                                <div class="rounded-circle bg-success d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <i class="fas fa-check text-white" style="font-size: 2rem;"></i>
                                </div>
                            </div>
                            
                            <h2 class="fw-bold text-dark mb-3">Nice to have you, <span id="welcomeUsername">dropshipper</span>.</h2>
                            <p class="text-muted mb-4">We are presently reviewing your account, and assuming all is well, it will be activated within the next 24 hours.</p>
                            
                            <button type="submit" class="btn btn-success px-5">
                                Create Account <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Step navigation
    document.getElementById('nextStep1').addEventListener('click', function() {
        const fullName = document.getElementById('full_name').value;
        if (fullName.trim() === '') {
            alert('Please enter your full name');
            return;
        }
        
        // Update progress bar
        document.getElementById('step2-circle').classList.remove('bg-secondary');
        document.getElementById('step2-circle').classList.add('bg-primary');
        
        // Hide step 1, show step 2
        document.getElementById('step1').classList.add('d-none');
        document.getElementById('step2').classList.remove('d-none');
    });

    document.getElementById('backStep1').addEventListener('click', function() {
        // Update progress bar
        document.getElementById('step2-circle').classList.remove('bg-primary');
        document.getElementById('step2-circle').classList.add('bg-secondary');
        
        // Hide step 2, show step 1
        document.getElementById('step2').classList.add('d-none');
        document.getElementById('step1').classList.remove('d-none');
    });

    document.getElementById('nextStep2').addEventListener('click', function() {
        const store = document.getElementById('store').value;
        const phone = document.getElementById('phone').value;
        const wilaya = document.getElementById('wilaya').value;
        
        if (store.trim() === '' || phone.trim() === '' || wilaya === '') {
            alert('Please fill in all required fields');
            return;
        }
        
        // Update progress bar
        document.getElementById('step3-circle').classList.remove('bg-secondary');
        document.getElementById('step3-circle').classList.add('bg-primary');
        
        // Update welcome message with full name
        const fullName = document.getElementById('full_name').value;
        document.getElementById('welcomeUsername').textContent = fullName;
        
        // Hide step 2, show step 3
        document.getElementById('step2').classList.add('d-none');
        document.getElementById('step3').classList.remove('d-none');
    });

    // Image upload preview
    document.getElementById('store_logo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('logo-preview');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" class="img-thumbnail mt-2" style="max-width: 150px; max-height: 150px;">`;
            };
            reader.readAsDataURL(file);
        } else {
            preview.innerHTML = '';
        }
    });
</script>
@endsection