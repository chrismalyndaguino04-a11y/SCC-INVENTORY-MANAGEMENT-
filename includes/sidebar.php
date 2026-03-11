<style>
    /* 1. Base Logo Style */
    .sidebar-brand-icon img {
        width: 40px; 
        height: auto;
        transition: all 0.2s ease-in-out;
    }

    /* 2. Fix for Collapsed Sidebar */
    /* When the <ul> has the class .toggled, we shrink the logo */
    .sidebar.toggled .sidebar-brand-icon img {
        width: 25px;
    }

    /* 3. Optional: Smooth transition for the text appearing/disappearing */
    .sidebar-brand-text {
        transition: opacity 0.2s ease-in-out;
    }
</style>

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="Dashboard.php">
        <div class="sidebar-brand-icon">
            <img src="img/css.png" alt="SCC Logo">
        </div>
        <div class="sidebar-brand-text mx-3">SCC Inventory</div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item active">
        <a class="nav-link" href="Dashboard.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Core Management
    </div>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseItems"
            aria-expanded="true" aria-controls="collapseItems">
            <i class="fas fa-fw fa-desktop"></i>
            <span>Manage Items</span>
        </a>
        <div id="collapseItems" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Item Actions:</h6>
                <a class="collapse-item" href="Item_registration.php">Item Registration</a>
                <a class="collapse-item" href="Itemlist.php">Item List</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDept"
            aria-expanded="true" aria-controls="collapseDept">
            <i class="fas fa-fw fa-building"></i>
            <span>Manage Department</span>
        </a>
        <div id="collapseDept" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Department Actions:</h6>
                <a class="collapse-item" href="Department_registration.php">Add Department</a>
                <a class="collapse-item" href="Department_list.php">Department List</a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Reports & Inventory
    </div>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseInventory"
            aria-expanded="true" aria-controls="collapseInventory">
            <i class="fas fa-fw fa-clipboard-list"></i>
            <span>Inventory Movement</span>
        </a>
        <div id="collapseInventory" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Stock Handling:</h6>
                <a class="collapse-item" href="stock_in.php">Stock In / Receive</a>
                <a class="collapse-item" href="stock_out.php">Stock Out / Issue</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Account:</h6>
                <a class="collapse-item" href="logout.php">Logout</a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>