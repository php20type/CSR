<div class="bg-dark text-white p-3" style="height: 100vh;">
    <ul class="nav flex-column">
        <!-- Dashboard Link -->
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.dashboard') }}">
                <i class="fa fa-tachometer-alt"></i> Dashboard
            </a>
        </li>

        <!-- NGOs Section -->
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('ngos.index') }}">
                <i class="fa fa-hand-holding-heart"></i> NGOs
            </a>
        </li>

        <!-- Add NGO -->
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('ngos.create') }}">
                <i class="fa fa-plus-circle"></i> Add NGO
            </a>
        </li>

        <!-- Show Bills -->
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('bills.index') }}">
                <i class="fa fa-file-invoice-dollar"></i> Bills
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('settings.index') }}">
                <i class="fa fa-gear"></i> Settings
            </a>
        </li>
    </ul>
</div>
