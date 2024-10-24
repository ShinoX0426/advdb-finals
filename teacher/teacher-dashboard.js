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


document.addEventListener('DOMContentLoaded', function () {
    // Additional Elements
    const addActivityBtn = document.getElementById('addActivityBtn');
    const addActivityModal = document.getElementById('addActivityModal');
    const addActivityForm = document.getElementById('addActivityForm');
    const activitiesList = document.querySelector('.activities-list');
    const courseTitle = document.getElementById('courseTitle');

    // Event Listeners
    if (addActivityBtn) addActivityBtn.addEventListener('click', openAddActivityModal);
    if (addActivityModal) {
        addActivityModal.querySelector('.close').addEventListener('click', closeAddActivityModal);
    }
    if (addActivityForm) addActivityForm.addEventListener('submit', handleAddActivity);
    if (courseTitle) courseTitle.addEventListener('change', updateCourseTitle);

    // Sample Activities Data
    const activities = [
        {
            type: 'homework',
            description: 'Homework',
            dueDate: 'Oct 20'
        },
        {
            type: 'quiz',
            description: 'Quiz',
            dueDate: 'Oct 22'
        },
        {
            type: 'project',
            description: 'Group Project',
            dueDate: 'Nov 5'
        }
    ];

    function openAddActivityModal() {
        addActivityModal.style.display = 'block';
        addActivityModal.classList.add('fade-in');
    }

    function closeAddActivityModal() {
        addActivityModal.classList.remove('fade-in');
        addActivityModal.style.display = 'none';
    }

    function handleAddActivity(e) {
        e.preventDefault();
        const formData = new FormData(addActivityForm);
        const newActivity = {
            type: formData.get('type'),
            description: formData.get('description'),
            dueDate: new Date(formData.get('dueDate')).toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric'
            })
        };

        // In a real application, you would send this to the server
        activities.push(newActivity);
        renderActivities();

        addActivityForm.reset();
        closeAddActivityModal();
    }

    function updateCourseTitle(e) {
        const title = e.target.value || 'Course Activities';
        document.querySelector('.activities h2').textContent = title;
    }

    function renderActivities() {
        activitiesList.innerHTML = '';

        activities.forEach(activity => {
            const item = document.createElement('div');
            item.className = 'activity-item';

            item.innerHTML = `
                <span class="activity-type ${activity.type}">${activity.type}</span>
                <span class="activity-description">${activity.description}</span>
                <span class="due-date">due: ${activity.dueDate}</span>
                <div class="activity-actions">
                    <button class="btn-small edit">Edit</button>
                    <button class="btn-small delete">Delete</button>
                </div>
            `;

            activitiesList.appendChild(item);
        });
    }

    // Set initial course title
    courseTitle.value = "Advanced Calculus and Linear Algebra";
    updateCourseTitle({ target: courseTitle });

    // Initial render
    renderActivities();
});