<div id="menu">
    <div id="menu_items_left">

        <a href="/"
        @if (Route::currentRouteName() == "welcome") class="menu_selected" @endif
        >Welcome</a>

        <a href="{{ route("estampas.index") }}"
        @if (Route::currentRouteName() == "estampas.index" || Route::currentRouteName() == "estampas.filter") class="menu_selected" @endif
        >Catalog</a>

    </div>
    <div id="menu_items_right">

        @auth
            <div id="menu_dropdown">
                <a href="" id="user_menu_href">
                    <?php
                        $name = Auth::user()->name;
                        echo ((strlen($name) > 15) ? substr($name, 0, 12) . "..." : substr($name, 0, 16));
                    ?>
                    <svg class="menu_dropdown_arrow" viewBox="0 0 24 24">
                        <path d="M0 16.67l2.829 2.83 9.175-9.339 9.167 9.339 2.829-2.83-11.996-12.17z"/>
                    </svg>
                </a>


                <div id="menu_dropdown_items" class="invisible">
                    <a href="
                @if(Auth::user()->tipo == 'C')
                    {{ route('clientes.edit', ['cliente' => Auth::user()->id]) }}
                @else
                    {{ route('users.edit', ['user' => Auth::user()->id]) }}
                @endif
                    ">Edit</a>
                    <a href="" id="logout_href">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="logout_menu_form"> @csrf </form>
                </div>
            </div>
        @else
            <a href="{{ route("clientes.create") }}"
            @if (Route::currentRouteName() == "clientes.create") class="menu_selected" @endif
            >Register</a>

            <a href="{{ route("login") }}"
            @if (Route::currentRouteName() == "login") class="menu_selected" @endif
            >Login</a>
        @endguest

    </div>
</div>
<!-- { {route('users.edit', [id => Auth::user()->id]) }} -->
