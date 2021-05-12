<div id="menu">
    <div id="menu_items_left">

        <a href="/"
        @if (!empty($title) && $title == "Welcome to MagicShirts!") class="menu_selected" @endif
        >Welcome</a>

        <a href="/stamps/"
        @if (!empty($title) && $title == "Catalog") class="menu_selected" @endif
        >Catalog</a>

    </div>
    <div id="menu_items_right">

        <a href="/clientes/create"
        @if (!empty($title) && $title == "Register now!") class="menu_selected" @endif
        >Register</a>

        <a href="/login/"
        @if (!empty($title) && $title == "Login") class="menu_selected" @endif
        >Login</a>

    </div>
</div>
