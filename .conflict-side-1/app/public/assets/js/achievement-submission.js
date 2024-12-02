class AchievementForm {
    constructor() {
        this.initSelect2();
        this.initEventListeners();
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

    initEventListeners() {
        // File input listeners
        document.querySelectorAll('.custom-file-input').forEach(input => {
            input.addEventListener('change', this.handleFileInput);
        });

        // Initial setup for supervisors and team members
        document.querySelector('select[name="supervisors[]"]').addEventListener('change', this.updateSupervisorOptions);
        document.querySelector('select[name="teamMembers[]"]').addEventListener('change', this.updateTeamMemberOptions);
        
        // Competition points calculation
        const rankSelect = document.getElementById('competitionRank');
        const levelSelect = document.getElementById('competitionLevel');
        rankSelect.addEventListener('change', this.calculatePoints);
        levelSelect.addEventListener('change', this.calculatePoints);

        // Number of students change handler
        const numberOfStudentsInput = document.getElementById('numberOfStudents');
        numberOfStudentsInput.addEventListener('change', this.handleNumberOfStudentsChange);
        this.handleNumberOfStudentsChange(); // Initial check

        this.updateSupervisorOptions();
        this.updateTeamMemberOptions();
    }

    handleFileInput(e) {
        const fileName = this.files[0]?.name || 'Pilih file';
        const label = this.nextElementSibling;
        label.textContent = fileName;
    }

    getSelectedSupervisors() {
        const supervisorSelects = document.querySelectorAll('select[name="supervisors[]"]');
        return Array.from(supervisorSelects).map(select => select.value).filter(value => value !== '');
    }

    getSelectedTeamMembers() {
        const teamMemberSelects = document.querySelectorAll('select[name="teamMembers[]"]');
        return Array.from(teamMemberSelects).map(select => select.value).filter(value => value !== '');
    }

    updateSupervisorOptions = () => {
        const selectedSupervisors = this.getSelectedSupervisors();
        const supervisorSelects = document.querySelectorAll('select[name="supervisors[]"]');
        
        supervisorSelects.forEach(select => {
            const currentValue = select.value;
            Array.from(select.options).forEach(option => {
                if (option.value) {
                    option.disabled = selectedSupervisors.includes(option.value) && option.value !== currentValue;
                }
            });
        });
    }

    updateTeamMemberOptions = () => {
        const selectedMembers = this.getSelectedTeamMembers();
        const teamMemberSelects = document.querySelectorAll('select[name="teamMembers[]"]');
        
        teamMemberSelects.forEach(select => {
            const currentValue = select.value;
            Array.from(select.options).forEach(option => {
                if (option.value) {
                    option.disabled = selectedMembers.includes(option.value) && option.value !== currentValue;
                }
            });
        });
    }

    addSupervisor() {
        const container = document.getElementById('supervisorContainer');
        const newInput = document.createElement('div');
        newInput.className = 'input-group mb-2';
        newInput.innerHTML = `
            <select class="form-control select2-dropdown" name="supervisors[]" required>
                <option value="">Pilih Dosen Pembimbing</option>
                ${window.LECTURER_OPTIONS}
            </select>
            <div class="input-group-append">
                <button type="button" class="btn btn-success" onclick="achievementForm.addSupervisor()">
                    <i class="fas fa-plus">+</i>
                </button>
                <button type="button" class="btn btn-danger" onclick="achievementForm.removeSupervisor(this)">
                    <i class="fas fa-minus">-</i>
                </button>
            </div>
        `;
        container.appendChild(newInput);
        
        $(newInput).find('.select2-dropdown').select2({
            width: '100%',
            placeholder: 'Cari dosen pembimbing...',
            allowClear: true
        });
        
        const newSelect = newInput.querySelector('select');
        newSelect.addEventListener('change', this.updateSupervisorOptions);
        this.updateSupervisorOptions();
    }

    addTeamMember() {
        const numberOfStudents = parseInt(document.getElementById('numberOfStudents').value) || 0;
        const currentMembers = document.querySelectorAll('#teamMemberContainer .input-group').length;
        const hasPersonalRole = Array.from(document.querySelectorAll('select[name="teamMemberRoles[]"]'))
            .some(select => select.value === 'Personal');
        
        if (hasPersonalRole) {
            alert('Prestasi personal tidak dapat memiliki anggota tim tambahan');
            return;
        }
        
        if (currentMembers >= numberOfStudents) {
            alert('Jumlah anggota tim tidak boleh melebihi jumlah siswa peserta');
            return;
        }
        
        const container = document.getElementById('teamMemberContainer');
        const newInput = document.createElement('div');
        newInput.className = 'input-group mb-2';
        newInput.innerHTML = `
            <select class="form-control select2-dropdown" name="teamMembers[]" required>
                <option value="">Pilih Anggota Tim</option>
                ${window.STUDENT_OPTIONS}
            </select>
            <select class="form-control" name="teamMemberRoles[]" required>
                <option value="">Pilih Peran</option>
                <option value="Ketua">Ketua</option>
                <option value="Anggota">Anggota</option>
                <option value="Personal">Personal</option>
            </select>
            <div class="input-group-append">
                <button type="button" class="btn btn-success" onclick="achievementForm.addTeamMember()">
                    <i class="fas fa-plus">+</i>
                </button>
                <button type="button" class="btn btn-danger" onclick="achievementForm.removeTeamMember(this)">
                    <i class="fas fa-minus">-</i>
                </button>
            </div>
        `;
        container.appendChild(newInput);
        
        $(newInput).find('.select2-dropdown').select2({
            width: '100%',
            placeholder: 'Cari anggota tim...',
            allowClear: true
        });
        
        const newSelect = newInput.querySelector('select[name="teamMembers[]"]');
        newSelect.addEventListener('change', this.updateTeamMemberOptions);
        this.updateTeamMemberOptions();
    }

    removeSupervisor(button) {
        const inputGroup = button.closest('.input-group');
        if (inputGroup) {
            inputGroup.remove();
            this.updateSupervisorOptions();
        }
    }

    removeTeamMember(button) {
        const inputGroup = button.closest('.input-group');
        if (inputGroup) {
            inputGroup.remove();
            this.updateTeamMemberOptions();
        }
    }

    calculatePoints = () => {
        const rankSelect = document.getElementById('competitionRank');
        const levelSelect = document.getElementById('competitionLevel');
        const rankPoints = window.COMPETITION_RANKS[rankSelect.value]?.points ?? 0;
        const levelMultiplier = window.COMPETITION_LEVELS[levelSelect.value]?.multiplier ?? 1;
        const totalPoints = rankPoints * levelMultiplier;
        // You can use totalPoints as needed
    }

    handleNumberOfStudentsChange = () => {
        const numberOfStudents = parseInt(document.getElementById('numberOfStudents').value) || 0;
        const roleSelects = document.querySelectorAll('select[name="teamMemberRoles[]"]');
        
        roleSelects.forEach(select => {
            const personalOption = Array.from(select.options).find(option => option.value === 'Personal');
            if (personalOption) {
                if (numberOfStudents > 1) {
                    personalOption.disabled = true;
                    if (select.value === 'Personal') {
                        select.value = '';
                    }
                } else {
                    personalOption.disabled = false;
                }
            }
        });
    }
}

// Initialize the form
const achievementForm = new AchievementForm(); 