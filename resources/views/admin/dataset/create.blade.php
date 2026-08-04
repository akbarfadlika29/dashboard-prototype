@extends('layouts.admin')

@section('title', 'Tambah Dataset')
@section('subtitle', 'Buat dataset manual dengan wizard step-by-step')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 md:p-10">
        <div class="flex items-start justify-between gap-4 flex-col md:flex-row">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Tambah Dataset</h1>
                <p class="text-slate-500 mt-1">Lengkapi informasi, susun kolom, lalu simpan dataset.</p>
            </div>
            <a 
                href="{{ route('dataset.index') }}" 
                class="inline-flex items-center gap-2
                    px-5 py-2.5 
                    rounded-xl 
                    border border-slate-300 
                    bg-white 
                    text-slate-700
                    font-medium
                    shadow-sm
                    hover:bg-slate-50
                    hover:border-slate-400
                    transition-all duration-200">
                    <svg 
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    <span>Kembali ke Daftar</span>
                </a>
        </div>
    </div>

    <form method="POST" action="{{ route('dataset.store') }}" id="datasetForm">
        @csrf

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 md:p-10">
            <div class="grid grid-cols-3 gap-3 mb-8" id="stepIndicator">
                <div class="step-pill active">1. Informasi</div>
                <div class="step-pill">2. Kolom</div>
                <div class="step-pill">3. Preview</div>
            </div>

            <div class="step-content" data-step="0">
                <div class="grid md:grid-cols-2 gap-7">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Dataset <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" id="nama" 
                            class="
                                w-full
                                border-2
                                border-slate-300 
                                rounded-2xl 
                                px-5
                                py-3.5
                                
                                text-slate-800
                                
                                placeholder:text-slate-400
                                
                                shadow-sm
                                
                                focus:border-emerald-500
                                focus:ring-4
                                focus:ring-emerald-100
                                
                                transition" 
                            
                            placeholder="Contoh: Data Pernikahan 2026">
                        <p class="text-xs text-red-500 mt-1 hidden" data-error="nama"></p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Kategori <span class="text-red-500">*</span></label>
                        <select name="kategori_id" id="kategori_id" 
                            class="
                                w-full
                                border-2 
                                border-slate-300
                                rounded-2xl 
                                px-5
                                py-3.5
                                bg-white
                                shadow-sm
                                focus:border-emerald-500
                                focus:ring-4
                                focus:ring-emerald-100
                                transition">
                            <option value="">Pilih Kategori</option>
                            @foreach($kategori as $k)
                                <option value="{{ $k->id }}">{{ $k->nama }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-red-500 mt-1 hidden" data-error="kategori_id"></p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Seksi <span class="text-red-500">*</span></label>
                        <select name="seksi_id" id="seksi_id" 
                            class="
                                w-full
                                border-2 
                                border-slate-300
                                rounded-2xl 
                                px-5
                                py-3.5
                                bg-white
                                shadow-sm
                                focus:border-emerald-500
                                focus:ring-4
                                focus:ring-emerald-100
                                transition">
                            <option value="">Pilih Seksi</option>
                            @foreach($seksi as $s)
                                <option value="{{ $s->id }}">{{ $s->nama }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-red-500 mt-1 hidden" data-error="seksi_id"></p>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium mb-1">Deskripsi</label>
                        <textarea name="deskripsi" rows="4" 
                            class="
                                w-full
                                border-2 
                                border-slate-300
                                rounded-2xl 
                                px-5
                                py-4
                                resize-y
                                shadow-sm
                                focus:ring-4
                                focus:ring-emerald-100
                                focus:border-emerald-500
                                transition" placeholder="Deskripsi singkat dataset..."></textarea>
                    </div>
                </div>
            </div>

            <div class="step-content hidden" data-step="1">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="font-semibold text-slate-800">Struktur Kolom</h2>
                        <p class="text-sm text-slate-500">Tambahkan minimal satu kolom.</p>
                    </div>
                    <button type="button" onclick="addColumn()" class="px-4 py-2 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700">+ Tambah Kolom</button>
                </div>

                <div id="columns-wrapper" class="space-y-3"></div>
                <p class="text-xs text-red-500 mt-2 hidden" data-error="kolom"></p>
            </div>

            <div class="step-content hidden" data-step="2">
                <div class="mb-4">
                    <h2 class="font-semibold text-slate-800">Preview Dataset</h2>
                    <p class="text-sm text-slate-500">Periksa rancangan tabel sebelum disimpan.</p>
                </div>

                <div class="rounded-2xl border border-slate-200 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="bg-slate-100" id="previewHead"></thead>
                            <tbody id="previewBody"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between pt-8 mt-8 border-t border-slate-200">
                <button type="button" id="backBtn" onclick="prevStep()" 
                    class="
                        inline-flex
                        items-center
                        gap-2
                        px-5 
                        py-3 
                        rounded-xl 
                        border 
                        border-slate-300
                        bg-white
                        text-slate-700
                        font-medium
                        shadow-sm 
                        hover:bg-slate-100
                        hover:border-slate-400
                        transition
                        hidden">
                        
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        <span>Kembali</span>
                    </button>
                <div class="ml-auto flex gap-2">
                    <button type="button" id="nextBtn" onclick="nextStep()" 
                        class="
                            inline-flex
                            items-center
                            gap-2
                            px-6
                            py-3 
                            rounded-xl 
                            text-white
                            bg-blue-600 
                            font-semibold
                            shadow-md
                            hover:bg-blue-700
                            hover:shadow-lg
                            transition">Next →</button>
                    <button type="submit" id="submitBtn" 
                        class="
                            inline-flex
                            items-center
                            gap-2
                            px-6 
                            py-3 
                            rounded-xl 
                            bg-emerald-600 
                            font-semibold
                            text-white 
                            shadow-md
                            hover:bg-emerald-700
                            hover:shadow-xl
                            transition">Simpan Dataset</button>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
.step-pill{
    display:flex;
    align-items:center;
    justify-content:center;

    padding:1rem 1.25rem;

    border-radius:16px;

    background:#f8fafc;

    border: 1px solid #e2e8f0;

    font-weight:600;

    color:#64748b;

    transition:.25s;
    
    min-height:64px;
}

.step-pill.active{
    background:linear-gradient(
        135deg,
        #059669,
        #10b981
    );

    color:white;

    border-color:#10b981;

    box-shadow:0 10px 20px rgba(16,185,129,.25);

    transform:translateY(-2px);
}
</style>

<script>
let currentStep = 0;
const totalSteps = 3;

function showStep(step){
    currentStep = step;
    document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));
    document.querySelector(`.step-content[data-step="${step}"]`).classList.remove('hidden');

    document.querySelectorAll('.step-pill').forEach((el,i)=>{
        el.classList.toggle('active', i===step);
    });

    document.getElementById('backBtn').classList.toggle('hidden', step===0);
    document.getElementById('nextBtn').classList.toggle('hidden', step===2);
    document.getElementById('submitBtn').classList.toggle('hidden', step!==2);

    if(step===2) renderPreview();
}

function clearErrors(){
    document.querySelectorAll('[data-error]').forEach(e=>{e.textContent='';e.classList.add('hidden')});
}

function setError(name,msg){
    const el=document.querySelector(`[data-error="${name}"]`);
    if(el){el.textContent=msg;el.classList.remove('hidden');}
}

function validateStep(){
    clearErrors();
    if(currentStep===0){
        let ok=true;
        if(!nama.value.trim()){setError('nama','Nama dataset wajib diisi');ok=false;}
        if(!kategori_id.value){setError('kategori_id','Kategori wajib dipilih');ok=false;}
        if(!seksi_id.value){setError('seksi_id','Seksi wajib dipilih');ok=false;}
        return ok;
    }
    if(currentStep===1){
        const rows=document.querySelectorAll('.column-row');
        if(rows.length===0){setError('kolom','Minimal 1 kolom harus ditambahkan');return false;}
        let ok=true;
        rows.forEach((row,i)=>{
            const inp=row.querySelector('input');
            if(!inp.value.trim()) ok=false;
        });
        if(!ok) setError('kolom','Semua nama kolom wajib diisi');
        return ok;
    }
    return true;
}

function nextStep(){ if(validateStep()) showStep(currentStep+1); }
function prevStep(){ showStep(currentStep-1); }

function addColumn(name='',type='text'){
    const wrap=document.getElementById('columns-wrapper');
    const index=wrap.querySelectorAll('.column-row').length;
    const row=document.createElement('div');
    row.className='column-row grid md:grid-cols-12 gap-3 items-center';
    row.innerHTML=`
        <input name="kolom[${index}][name]" value="${name}" placeholder="Nama Kolom" class="md:col-span-7 rounded-xl border-slate-300 px-3 py-2 border">
        <select name="kolom[${index}][type]" class="md:col-span-4 rounded-xl border-slate-300 px-3 py-2 border">
            <option value="text">Text</option>
            <option value="number">Number</option>
            <option value="date">Date</option>
        </select>
        <button type="button" class="md:col-span-1 px-3 py-2 rounded-xl border text-red-600 hover:bg-red-50" onclick="this.parentElement.remove()">✕</button>`;
    wrap.appendChild(row);
    row.querySelector('select').value=type;
}

function renderPreview(){
    const names=[...document.querySelectorAll('.column-row input')].map(i=>i.value.trim()).filter(Boolean);
    const head=document.getElementById('previewHead');
    const body=document.getElementById('previewBody');

    if(names.length===0){
        head.innerHTML='<tr><th class="p-4 text-left">Belum ada kolom</th></tr>';
        body.innerHTML=''; return;
    }

    head.innerHTML='<tr>'+names.map(n=>`<th class="px-4 py-3 text-left font-semibold whitespace-nowrap">${n}</th>`).join('')+'</tr>';
    body.innerHTML='';
    for(let r=0;r<3;r++){
        body.innerHTML += '<tr class="border-t">'+names.map(()=>'<td class="px-4 py-3 text-slate-400">Sample Data</td>').join('')+'</tr>';
    }
}

addColumn();
showStep(0);
</script>
@endsection