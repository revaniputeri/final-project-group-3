class AchievementForm {
    constructor() {
        this.initSelect2();
    }

    initSelect2() {
        $('.dosen-pembimbing').select2({
            placeholder: 'Cari dosen pembimbing...',
            allowClear: true
        });
        $('.anggota-tim').select2({
            placeholder: 'Cari anggota tim...',
            allowClear: true
        });
        $('.anggota-tim-peran').select2({
            placeholder: 'Pilih peran...',
            allowClear: true
        });
    }

    addSupervisor() {
        const container = document.getElementById('supervisorContainer');
        const newInput = document.createElement('div');
        newInput.className = 'input-group mb-2';
        
        const optionsHtml = LECTURER_OPTIONS.map(lecturer => 
            `<option value="${lecturer.Id}">${lecturer.FullName}</option>`
        ).join('');

        newInput.innerHTML = `
            <select class="form-control select2-dropdown" name="supervisors[]" required>
                <option value="">Pilih Dosen Pembimbing</option>
                ${optionsHtml}
            </select>
            <div class="input-group-append">
                <button type="button" class="btn btn-success" onclick="achievementForm.addSupervisor()">
                    <i class="fas fa-plus">+</i>
                </button>
            </div>
        `;
        
        container.appendChild(newInput);
        $(newInput).find('.select2-dropdown').select2({
            width: '100%',
            placeholder: 'Cari dosen pembimbing...',
            allowClear: true
        });
    }
}

// Initialize the form
const achievementForm = new AchievementForm(); 