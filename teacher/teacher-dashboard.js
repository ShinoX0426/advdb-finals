document.addEventListener('DOMContentLoaded', function () {
    // Elements
    const addStudentBtn = document.getElementById('addStudentBtn');
    const addStudentModal = document.getElementById('addStudentModal');
    const closeModal = addStudentModal.querySelector('.close');
    const addStudentForm = document.getElementById('addStudentForm');
    const searchStudent = document.getElementById('searchStudent');
    const classListTable = document.querySelector('.class-list table tbody');
    const studentProfile = document.getElementById('student-profile');
    const violationReportForm = document.getElementById('violationReportForm');

    // Event Listeners
    addStudentBtn.addEventListener('click', openAddStudentModal);
    closeModal.addEventListener('click', closeAddStudentModal);
    addStudentForm.addEventListener('submit', handleAddStudent);
    searchStudent.addEventListener('input', handleSearchStudent);
    classListTable.addEventListener('click', handleStudentActions);
    violationReportForm.addEventListener('submit', handleViolationReport);

    // Functions
    function openAddStudentModal() {
        addStudentModal.style.display = 'block';
        addStudentModal.classList.add('fade-in');
    }

    function closeAddStudentModal() {
        addStudentModal.classList.remove('fade-in');
        addStudentModal.style.display = 'none';
    }

    function handleAddStudent(e) {
        e.preventDefault();
        const formData = new FormData(addStudentForm);
        // Here you would typically send the form data to the server
        // For this example, we'll just log it and close the modal
        console.log('New student data:', Object.fromEntries(formData));
        addStudentForm.reset();
        closeAddStudentModal();
        // TODO: Add the new student to the table
    }

    function handleSearchStudent() {
        const searchTerm = searchStudent.value.toLowerCase();
        const rows = classListTable.querySelectorAll('tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    }

    function handleStudentActions(e) {
        const target = e.target;

        if (target.classList.contains('view-profile')) {
            const row = target.closest('tr');
            const studentId = row.cells[0].textContent;
            const studentName = row.cells[1].textContent;
            showStudentProfile(studentId, studentName);
        } else if (target.classList.contains('edit')) {
            const row = target.closest('tr');
            const studentId = row.cells[0].textContent;
            editStudent(studentId);
        } else if (target.classList.contains('delete')) {
            const row = target.closest('tr');
            const studentId = row.cells[0].textContent;
            deleteStudent(studentId);
        }
    }

    function showStudentProfile(studentId, studentName) {
        // Here you would typically fetch the student's full profile from the server
        // For this example, we'll just update the profile with the available information
        studentProfile.querySelector('h3').textContent = studentName;
        studentProfile.querySelector('p:first-of-type').innerHTML = `<strong>ID:</strong> ${studentId}`;

        studentProfile.classList.remove('hidden');
        studentProfile.scrollIntoView({ behavior: 'smooth' });
    }

    function editStudent(studentId) {
        // Here you would typically open a form to edit the student's information
        console.log(`Editing student with ID: ${studentId}`);
        // TODO: Implement edit functionality
    }

    function deleteStudent(studentId) {
        if (confirm(`Are you sure you want to delete student with ID: ${studentId}?`)) {
            // Here you would typically send a request to the server to delete the student
            console.log(`Deleting student with ID: ${studentId}`);
            // TODO: Remove the student from the table after successful deletion
        }
    }

    function handleViolationReport(e) {
        e.preventDefault();
        const formData = new FormData(violationReportForm);
        // Here you would typically send the form data to the server
        // For this example, we'll just log it
        console.log('Violation report:', Object.fromEntries(formData));
        violationReportForm.reset();
        alert('Violation report submitted successfully!');
    }

    // Simulated data loading
    function loadClassList() {
        const sampleData = [
            { id: '001', name: 'John Doe', grade: '10', performance: 'Excellent', attendance: '98%' },
            { id: '002', name: 'Jane Smith', grade: '10', performance: 'Good', attendance: '95%' },
            { id: '003', name: 'Bob Johnson', grade: '10', performance: 'Average', attendance: '92%' },
        ];

        sampleData.forEach(student => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${student.id}</td>
                <td>${student.name}</td>
                <td>${student.grade}</td>
                <td>${student.performance}</td>
                <td>${student.attendance}</td>
                <td>
                    <button class="btn-small view-profile">View</button>
                    <button class="btn-small edit">Edit</button>
                    <button class="btn-small delete">Delete</button>
                </td>
            `;
            classListTable.appendChild(row);
        });
    }

    // Load initial data
    loadClassList();
});