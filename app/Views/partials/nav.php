<nav class="navbar navbar-expand-lg navbar-dark navbar-custom py-3">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold" href="/dashboard">Clinic CRM</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto align-items-center">
                <li class="nav-item me-4">
                    <a class="nav-link <?= $_SERVER['REQUEST_URI'] === '/dashboard' ? 'active text-white fw-bold' : '' ?>" href="/dashboard">Dashboard</a>
                </li>
                
                <li class="nav-item d-flex align-items-center me-4">
                    <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/patients') !== false && strpos($_SERVER['REQUEST_URI'], 'create') === false ? 'active text-white fw-bold' : '' ?>" href="/patients">Patients</a>
                    <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/patients/create') !== false ? 'active text-white fw-bold' : '' ?>" href="/patients/create"> Create Patient</a>
                </li>
                
                <li class="nav-item d-flex align-items-center">
                    <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/appointments') !== false && strpos($_SERVER['REQUEST_URI'], 'create') === false ? 'active text-white fw-bold' : '' ?>" href="/appointments">Appointments</a>
                    <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/appointments/create') !== false ? 'active text-white fw-bold' : '' ?>" href="/appointments/create"> Create Appointment</a>
                </li>
            </ul>
            
            <?php if (!empty($_SESSION['user_id'])): ?>
                <form action="/logout" method="POST" class="d-flex align-items-center m-0">
                    <span class="text-light me-3 fw-medium"><?= e((string)$_SESSION['user_name']) ?></span>
                    <button type="submit" class="btn btn-sm btn-outline-danger">Logout</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</nav>  