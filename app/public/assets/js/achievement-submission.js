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
        const supervisorSelect = document.querySelector('select[name="supervisors[]"]');
        const teamMemberSelect = document.querySelector('select[name="teamMembers[]"]');

        if (supervisorSelect) {
            supervisorSelect.addEventListener('change', this.updateSupervisorOptions);
        }

        if (teamMemberSelect) {
            teamMemberSelect.addEventListener('change', this.updateTeamMemberOptions);
        }

        // Competition points calculation
        const rankSelect = document.getElementById('competitionRank');
        const levelSelect = document.getElementById('competitionLevel');
        if (rankSelect && levelSelect) {
            rankSelect.addEventListener('change', this.calculatePoints);
            levelSelect.addEventListener('change', this.calculatePoints);
        }

        // lavina
        // Number of students change handler
        const numberOfStudentsInput = document.getElementById('numberOfStudentsEdit');
        if (numberOfStudentsInput) {
            numberOfStudentsInput.addEventListener('change', this.handleNumberOfStudentsChange);
        }

        this.updateSupervisorOptions();
        this.updateTeamMemberOptions();
    }

    handleFileInput(e) {
        const fileName = this.files[0]?.name || 'Pilih file';
        const label = this.nextElementSibling;
        if (label) {
            label.textContent = fileName;
        }
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

    addSupervisor = () => {
        const container = document.getElementById('supervisorContainer');
        if (!container) return;

        const newInput = document.createElement('div');
        newInput.className = 'input-group mb-2';

        newInput.innerHTML = `
            <select class="form-control dosen-pembimbing" name="supervisors[]">
                <option value="">Pilih Dosen Pembimbing</option>
                ${window.LECTURER_OPTIONS || ''}
            </select>
            <div class="input-group-append">
                <button type="button" class="btn btn-danger" onclick="window.achievementForm.removeTeamMember(this)">
                    <i class="fas fa-minus">-</i>
                </button>
                <button type="button" class="btn btn-success" onclick="achievementForm.addSupervisor()">
                    <i class="fas fa-plus">+</i>
                </button>
            </div>
        `;
        container.appendChild(newInput);

        // Initialize select2 dengan width yang sesuai
        $(newInput).find('.dosen-pembimbing').select2({
            placeholder: 'Cari dosen pembimbing...',
            allowClear: true,
        });

        this.updateSupervisorOptions();
    }

    addTeamMember = () => {
        const numberOfStudentsInput = document.getElementById('numberOfStudents') ?? document.getElementById('numberOfStudentsEdit');
        const container = document.getElementById('teamMemberContainer');
        if (!numberOfStudentsInput || !container) return;

        const numberOfStudents = parseInt(numberOfStudentsInput.value) || 0;
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

        const newInput = document.createElement('div');
        newInput.className = 'input-group mb-2';

        let roleOptions = '';
        if (numberOfStudents === 1) {
            roleOptions = `
                <option value="">Pilih Peran</option>
                <option value="Personal">Personal</option>
            `;
        } else {
            roleOptions = `
                <option value="">Pilih Peran</option>
                <option value="Ketua">Ketua</option>
                <option value="Anggota">Anggota</option>
                <option value="Personal">Personal</option>
            `;
        }

        newInput.innerHTML = `
            <select class="form-control select2-dropdown" name="teamMembers[]" required>
                <option value="">Pilih Anggota Tim</option>
                ${window.STUDENT_OPTIONS || ''}
            </select>
            <select class="form-control select2-dropdown" name="teamMemberRoles[]" required>
                ${roleOptions}
            </select>
            <div class="input-group-append">
                <button type="button" class="btn btn-danger" onclick="window.achievementForm.removeTeamMember(this)">
                    <i class="fas fa-minus">-</i>
                </button>
                <button type="button" class="btn btn-success" onclick="window.achievementForm.addTeamMember()">
                    <i class="fas fa-plus">+</i>
                </button>
            </div>
        `;
        container.appendChild(newInput);

        $(newInput).find('.select2-dropdown').select2({
            placeholder: 'Cari anggota tim...',
            allowClear: true
        });

        const newSelect = newInput.querySelector('select[name="teamMembers[]"]');
        if (newSelect) {
            newSelect.addEventListener('change', this.updateTeamMemberOptions);
            this.updateTeamMemberOptions();
        }
    }

    removeSupervisor(button) {
        const inputGroup = button?.closest('.input-group');
        if (inputGroup) {
            inputGroup.remove();
            this.updateSupervisorOptions();
        }
    }

    removeTeamMember(button) {
        const inputGroup = button?.closest('.input-group');
        if (inputGroup) {
            inputGroup.remove();
            this.updateTeamMemberOptions();
        }
    }

    calculatePoints = () => {
        const rankSelect = document.getElementById('competitionRank');
        const levelSelect = document.getElementById('competitionLevel');
        if (!rankSelect || !levelSelect || !window.COMPETITION_RANKS || !window.COMPETITION_LEVELS) return;

        const rankPoints = window.COMPETITION_RANKS[rankSelect.value]?.points ?? 0;
        const levelMultiplier = window.COMPETITION_LEVELS[levelSelect.value]?.multiplier ?? 1;
        const totalPoints = rankPoints * levelMultiplier;
        // You can use totalPoints as needed
    }

    handleNumberOfStudentsChange = () => {
        const numberOfStudentsInput = document.getElementById('numberOfStudents') ?? document.getElementById('numberOfStudentsEdit');
        if (!numberOfStudentsInput) return;

        const numberOfStudents = parseInt(numberOfStudentsInput.value) || 0;
        const roleSelects = document.querySelectorAll('select[name="teamMemberRoles[]"]');

        roleSelects.forEach(select => {
            // Reset select value
            $(select).find('option').each(function () {
                if ($(this).val() !== select.value) {
                    $(this).remove();
                }
            })

            // Add appropriate options based on number of students
            if (numberOfStudents === 1) {
                select.add(new Option('Pilih Peran', ''));
                select.add(new Option('Personal', 'Personal'));
            } else {
                select.add(new Option('Pilih Peran', ''));
                select.add(new Option('Ketua', 'Ketua'));
                select.add(new Option('Anggota', 'Anggota'));
            }
        });
    }
}

// Initialize the form
window.achievementForm = new AchievementForm();
