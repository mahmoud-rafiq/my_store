<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('site.index')}}">
        <div class="sidebar-brand-icon ">
            <i class="fas fa-shopping-cart"></i>
        </div>
        <div class="sidebar-brand-text mx-3">MY STORE</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('admin.index')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">



    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsecategory"
            aria-expanded="true" aria-controls="collapsecategory">
            <i class="fas fa-fw fa-tags"></i>
            <span>Categories</span>
        </a>
        <div id="collapsecategory" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{route('admin.categories.index')}}">All Categories</a>
                <a class="collapse-item" href="{{route('admin.categories.create')}}">Add New Category</a>
            </div>
        </div>
    </li>


    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseproduct"
            aria-expanded="true" aria-controls="collapseproduct">
            <i class="fas fa-fw fa-heart"></i>
            <span>Products</span>
        </a>
        <div id="collapseproduct" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{route('admin.products.index')}}">All Products</a>
                <a class="collapse-item" href="{{route('admin.products.create')}}">Add New Product</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="index.html">
            <i class="fas fa-fw fa-shopping-cart"></i>
            <span>Orders</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="index.html">
            <i class="fas fa-fw fa-credit-card"></i>
            <span>Payments</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="index.html">
            <i class="fas fa-fw fa-users"></i>
            <span>Users</span></a>
    </li>



    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
