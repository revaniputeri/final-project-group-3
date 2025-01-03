class AchievementForm {
    constructor() {
        this.currentStep = 1;
        $(document).ready(() => {
            this.initEventListeners();
        });
    }

    initSelect2() {
        $('.dosen-pembimbing').select2({
            placeholder: 'Cari dosen pembimbing...',
            allowClear: true,
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
        const supervisorSelects = document.querySelectorAll('select[name="supervisors[]"]');
        const teamMemberSelects = document.querySelectorAll('select[name="teamMembers[]"]');

        supervisorSelects.forEach(select => {
            select.addEventListener('change', this.updateSupervisorOptions);
        });

        teamMemberSelects.forEach(select => {
            select.addEventListener('change', this.updateTeamMemberOptions);
        });

        // Competition points calculation
        const rankSelect = document.getElementById('competitionRank');
        const levelSelect = document.getElementById('competitionLevel');
        rankSelect.addEventListener('change', this.calculatePoints);
        levelSelect.addEventListener('change', this.calculatePoints);

        // Number of students change handler
        const numberOfStudentsInput = document.getElementById('numberOfStudentsEdit') ?? document.getElementById('numberOfStudents');
        if (numberOfStudentsInput) {
            numberOfStudentsInput.addEventListener('change', this.handleNumberOfStudentsChange);
        }

        this.updateSupervisorOptions();
        this.updateTeamMemberOptions();

        const submitButton = document.getElementById('submitButton');
        if (submitButton) {
            submitButton.addEventListener('click', (event) => {
                if (!this.validateTeamMembers() || !this.validateDates()) {
                    event.preventDefault();
                }
            });
        }

        //prev and next button
        document.querySelectorAll('.next-step').forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                this.nextStep();
            });
        });

        document.querySelectorAll('.prev-step').forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                this.prevStep();
            });
        });
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
        const roleSelects = document.querySelectorAll('select[name="teamMemberRoles[]"]');

        teamMemberSelects.forEach(select => {
            const currentValue = select.value;
            Array.from(select.options).forEach(option => {
                if (option.value) {
                    option.disabled = selectedMembers.includes(option.value) && option.value !== currentValue;
                }
            });
        });

        const hasLeader = Array.from(roleSelects).some(select => select.value === 'Ketua');
        roleSelects.forEach(select => {
            if (hasLeader) {
                $(select).find('option[value="Ketua"]').prop('disabled', true);
            } else {
                $(select).find('option[value="Ketua"]').prop('disabled', false);
            }
        });
        this.handleNumberOfStudentsChange();
    }

    addSupervisor = () => {
        const container = document.getElementById('supervisorContainer');
        if (!container) return;

        const newInput = document.createElement('div');
        newInput.className = 'input-group mb-2';

        newInput.innerHTML = `
            <select class="form-control select2-dropdown dosen-pembimbing" name="supervisors[]">
                <option value="">Pilih Dosen Pembimbing</option>
                ${window.LECTURER_OPTIONS || ''}
            </select>
            <div class="input-group-append">
                <button type="button" class="btn btn-danger" onclick="window.achievementForm.removeSupervisor(this)">
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
            this.handleNumberOfStudentsChange();
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
        this.handleNumberOfStudentsChange();
        const inputGroup = button?.closest('.input-group');
        if (inputGroup) {
            inputGroup.remove();
            this.updateTeamMemberOptions();
            this.handleNumberOfStudentsChange();
        }
    }

    handleNumberOfStudentsChange = () => {
        const numberOfStudentsInput = document.getElementById('numberOfStudents') ?? document.getElementById('numberOfStudentsEdit');
        if (!numberOfStudentsInput) return;

        const numberOfStudents = parseInt(numberOfStudentsInput.value) || 0;
        const roleSelects = document.querySelectorAll('select[name="teamMemberRoles[]"]');

        roleSelects.forEach(select => {
            // Reset select value
            $(select).find('option').each(function () {
                $(this).prop('disabled', false);
            });

            if (numberOfStudents === 1) {
                $(select).find('option[value="Anggota"]').prop('disabled', true);
                $(select).find('option[value="Ketua"]').prop('disabled', true);
            } else {
                $(select).find('option[value="Personal"]').prop('disabled', true);
            }
        });
    }

    validateTeamMembers = () => {
        const numberOfStudentsInput = document.getElementById('numberOfStudents') ?? document.getElementById('numberOfStudentsEdit');
        const teamMemberInputs = document.querySelectorAll('select[name="teamMembers[]"]');
        const roleSelects = document.querySelectorAll('select[name="teamMemberRoles[]"]');

        const numberOfStudents = parseInt(numberOfStudentsInput.value) || 0;
        const currentMembers = Array.from(teamMemberInputs).filter(select => select.value !== '').length;

        if (currentMembers !== numberOfStudents) {
            alert(`Jumlah anggota tim (${currentMembers}) harus sesuai dengan jumlah siswa peserta (${numberOfStudents}).`);
            return false;
        }

        if (currentMembers > 1) {
            const hasLeader = Array.from(roleSelects).some(select => select.value === 'Ketua');
            if (!hasLeader) {
                alert('Tim yang memiliki lebih dari 1 anggota wajib memiliki ketua.');
                return false;
            }
        }

        // Retrieve roles of team members
        const roles = Array.from(roleSelects).map(select => select.value);

        // Validate number of students for personal achievement
        if (numberOfStudents > 1) {
            if (roles.some(role => role === 'Personal')) {
                alert('Prestasi personal hanya dapat dipilih untuk jumlah peserta 1 orang.');
                return false;
            }
        }

        // Ensure roles are not mixed between Personal and Team
        let hasPersonal = roles.some(role => role === 'Personal');
        let hasTeam = roles.some(role => role !== 'Personal');

        if (hasPersonal && hasTeam) {
            alert('Prestasi tidak dapat berupa personal dan tim secara bersamaan.');
            return false;
        }

        // Validate number of leaders
        if (hasTeam) {
            const leaderCount = roles.filter(role => role === 'Ketua').length;
            if (leaderCount !== 1) {
                alert('Tim harus memiliki satu ketua.');
                return false;
            }
        }

        this.handleNumberOfStudentsChange();
        return true;
    }

    validateDates = () => {
        const competitionStartDate = document.getElementById('competitionStartDate');
        const competitionEndDate = document.getElementById('competitionEndDate');
        const letterDate = document.getElementById('letterDate');

        const today = new Date();
        const currentDate = today.toISOString().split('T')[0]; // Format YYYY-MM-DD

        if (competitionStartDate.value > currentDate) {
            alert('Tanggal mulai kompetisi tidak boleh lebih dari tanggal saat ini.');
            return false;
        }

        if (competitionEndDate.value > currentDate) {
            alert('Tanggal selesai kompetisi tidak boleh lebih dari tanggal saat ini.');
            return false;
        }

        if (letterDate.value > currentDate) {
            alert('Tanggal surat tidak boleh lebih dari tanggal saat ini.');
            return false;
        }

        if (competitionStartDate.value > competitionEndDate.value) {
            alert('Tanggal mulai kompetisi tidak boleh lebih dari tanggal selesai kompetisi.');
            return false;
        }

        return true;
    }

    nextStep() {
        if (!this.validateStep(this.currentStep)) return;

        document.querySelector(`#step${this.currentStep}-indicator`).classList.add("step-done");

        document.getElementById('step' + this.currentStep).style.display = 'none';

        const progressBarItems = document.querySelectorAll('.form-wizard-steps li');
        progressBarItems[this.currentStep - 1].classList.remove('active');
        this.currentStep++;
        progressBarItems[this.currentStep - 1].classList.add('active');

        document.getElementById('step' + this.currentStep).style.display = 'block';

        if (this.currentStep === 5) {
            this.initSelect2();
        }
    }

    prevStep() {
        document.getElementById('step' + this.currentStep).style.display = 'none';

        document.querySelector(`#step${this.currentStep}-indicator`).classList.remove("step-done");

        const progressBarItems = document.querySelectorAll('.form-wizard-steps li');
        progressBarItems[this.currentStep - 1].classList.remove('active');
        this.currentStep--;
        progressBarItems[this.currentStep - 1].classList.add('active');

        document.getElementById('step' + this.currentStep).style.display = 'block';
    }

    validateStep(step) {
        if (step === 1) {
            // Validate step 1 inputs
            const competitionTitle = document.getElementById('competitionTitle').value.trim();
            const competitionTitleEnglish = document.getElementById('competitionTitleEnglish').value.trim();
            const competitionType = document.getElementById('competitionType').value;
            const competitionLevel = document.getElementById('competitionLevel').value;
            const competitionRank = document.getElementById('competitionRank').value;

            if (!competitionTitle) {
                alert('Judul Kompetisi (Bahasa Indonesia) wajib diisi');
                return false;
            }
            if (!competitionTitleEnglish) {
                alert('Judul Kompetisi (Bahasa Inggris) wajib diisi');
                return false;
            }
            if (!competitionType) {
                alert('Jenis Kompetisi wajib dipilih');
                return false;
            }
            if (!competitionLevel) {
                alert('Tingkat Kompetisi wajib dipilih');
                return false;
            }
            if (!competitionRank) {
                alert('Peringkat Kompetisi wajib dipilih');
                return false;
            }
            return true;

        } else if (step === 2) {
            // Validate step 2 inputs
            const competitionPlace = document.getElementById('competitionPlace').value.trim();
            const competitionPlaceEnglish = document.getElementById('competitionPlaceEnglish').value.trim();
            const competitionUrl = document.getElementById('competitionUrl').value.trim();
            const competitionStartDate = document.getElementById('competitionStartDate').value;
            const competitionEndDate = document.getElementById('competitionEndDate').value;

            if (!competitionPlace) {
                alert('Tempat/Penyelenggara Kompetisi (Bahasa Indonesia) wajib diisi');
                return false;
            }
            if (!competitionPlaceEnglish) {
                alert('Tempat/Penyelenggara Kompetisi (Bahasa Inggris) wajib diisi');
                return false;
            }
            if (!competitionUrl) {
                alert('URL Kompetisi wajib diisi');
                return false;
            }
            if (!competitionStartDate) {
                alert('Tanggal Mulai Kompetisi wajib diisi');
                return false;
            }
            if (!competitionEndDate) {
                alert('Tanggal Selesai Kompetisi wajib diisi');
                return false;
            }
            if (!this.validateDates()) {
                return false;
            }
            return true;
        } else if (step === 3) {
            // Validate step 3 inputs
            const letterNumber = document.getElementById('letterNumber').value.trim();
            const letterDate = document.getElementById('letterDate').value;

            if (!letterNumber) {
                alert('Nomor Surat wajib diisi');
                return false;
            }
            if (!letterDate) {
                alert('Tanggal Surat wajib diisi');
                return false;
            }
            return true;
        } else if (step === 4) {
            // Validate step 4 inputs
            const certificateFile = document.getElementById('certificateFile').files[0];
            const competitionPhoto = document.getElementById('documentationFile').files[0];
            const letterFile = document.getElementById('letterFile').files[0];
            const posterFile = document.getElementById('posterFile').files[0];

            if (!certificateFile) {
                alert('File Sertifikat wajib diupload');
                return false;
            }
            if (!competitionPhoto) {
                alert('Foto Kompetisi wajib diupload');
                return false;
            }
            if (!letterFile) {
                alert('File Surat wajib diupload');
                return false;
            }
            if (!posterFile) {
                alert('File Poster wajib diupload');
                return false;
            }
            return true;
        } else if (step === 5) {
            // Validate step 5 inputs - only team members
            const teamMembers = document.querySelectorAll('select[name="teamMembers[]"]');

            // Validate at least one team member is selected
            let teamMemberSelected = false;
            teamMembers.forEach(select => {
                if (select.value) teamMemberSelected = true;
            });
            if (!teamMemberSelected) {
                alert('Anggota harus diisi');
                return false;
            }

            return true;
        }
        return true;
    }
}

//instance of AchievementForm
window.achievementForm = new AchievementForm();