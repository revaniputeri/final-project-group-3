class AchievementForm {
    constructor() {
        this.initSelect2();
        this.initEventListeners();
        this.validateTeamSize();
    }

    initSelect2() {
        $('.select2-dropdown').select2({
            width: '100%',
            placeholder: 'Pilih...',
            allowClear: true
        });
    }

    initEventListeners() {
        // Listen for changes in number of students
        $('#numberOfStudents').on('change', () => this.validateTeamSize());

        // Listen for remove supervisor clicks
        $(document).on('click', '.remove-supervisor', function() {
            $(this).closest('.input-group').remove();
        });

        // Listen for remove team member clicks
        $(document).on('click', '.remove-team-member', function() {
            $(this).closest('.input-group').remove();
        });

        // Form submission validation
        $('form').on('submit', (e) => this.validateForm(e));
    }

    validateTeamSize() {
        const maxMembers = parseInt($('#numberOfStudents').val()) || 0;
        const currentMembers = $('#teamMemberContainer .input-group').length;

        if (currentMembers > maxMembers) {
            alert(`Jumlah anggota tim tidak boleh melebihi ${maxMembers} orang`);
            // Remove excess members
            $('#teamMemberContainer .input-group').slice(maxMembers).remove();
        }
    }

    addSupervisor() {
        const container = document.getElementById('supervisorContainer');
        const newInput = document.createElement('div');
        newInput.className = 'input-group mb-2';
        
        const optionsHtml = Array.from(document.querySelectorAll('#supervisorContainer select:first-child option'))
            .map(option => `<option value="${option.value}">${option.text}</option>`)
            .join('');

        newInput.innerHTML = `
            <select class="form-control select2-dropdown" name="supervisors[]" required>
                ${optionsHtml}
            </select>
            <div class="input-group-append">
                <button type="button" class="btn btn-danger remove-supervisor">
                    <i class="ti-trash"></i>
                </button>
            </div>
        `;
        
        container.appendChild(newInput);
        $(newInput).find('.select2-dropdown').select2({
            width: '100%',
            placeholder: 'Pilih Dosen Pembimbing...',
            allowClear: true
        });
    }

    addTeamMember() {
        const maxMembers = parseInt($('#numberOfStudents').val()) || 0;
        const currentMembers = $('#teamMemberContainer .input-group').length;

        if (currentMembers >= maxMembers) {
            alert(`Jumlah anggota tim tidak boleh melebihi ${maxMembers} orang`);
            return;
        }

        const container = document.getElementById('teamMemberContainer');
        const newInput = document.createElement('div');
        newInput.className = 'input-group mb-2';
        
        const optionsHtml = Array.from(document.querySelectorAll('#teamMemberContainer select:first-child option'))
            .map(option => `<option value="${option.value}">${option.text}</option>`)
            .join('');

        newInput.innerHTML = `
            <select class="form-control select2-dropdown" name="teamMembers[]">
                ${optionsHtml}
            </select>
            <select class="form-control" name="teamMemberRoles[]" style="width: 150px;">
                <option value="Ketua">Ketua</option>
                <option value="Anggota">Anggota</option>
            </select>
            <div class="input-group-append">
                <button type="button" class="btn btn-danger remove-team-member">
                    <i class="ti-trash"></i>
                </button>
            </div>
        `;
        
        container.appendChild(newInput);
        $(newInput).find('.select2-dropdown').select2({
            width: '100%',
            placeholder: 'Pilih Anggota Tim...',
            allowClear: true
        });
    }

    validateForm(e) {
        const numberOfStudents = parseInt($('#numberOfStudents').val()) || 0;
        const teamMembers = $('#teamMemberContainer .input-group').length;
        const supervisors = $('#supervisorContainer .input-group').length;

        if (teamMembers > numberOfStudents) {
            e.preventDefault();
            alert(`Jumlah anggota tim tidak boleh melebihi ${numberOfStudents} orang`);
            return false;
        }

        if (supervisors === 0) {
            e.preventDefault();
            alert('Minimal harus ada 1 dosen pembimbing');
            return false;
        }

        return true;
    }
}

// Initialize the form when the document is ready
document.addEventListener('DOMContentLoaded', function() {
    window.achievementForm = new AchievementForm();
}); 