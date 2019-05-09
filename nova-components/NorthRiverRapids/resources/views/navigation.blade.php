<h3 class="flex items-center font-normal text-white mb-6 text-base no-underline">
    <img class="sidebar-icon" src="/img/icons/swimmer.svg">
    <span class="sidebar-label">
        North River Rapids
    </span>
</h3>
<ul class="list-reset mb-8">
    <li class="leading-wide mb-4 text-sm">
        <a href="/roster" class="text-white ml-8 no-underline {{ request()->is('admin/resources/roster*') ? 'router-link-exact-active router-link-active' : '' }}">
            Roster
        </a>
    </li>
    <li class="leading-wide mb-4 text-sm">
        <a href="/admin/resources/roster" class="text-white ml-8 no-underline {{ request()->is('admin/resources/roster*') ? 'router-link-exact-active router-link-active' : '' }}">
            Swimmers
        </a>
    </li>
    <li class="leading-wide mb-4 text-sm">
        <a href="/admin/resources/athletes" class="text-white ml-8 no-underline {{ request()->is('admin/resources/athletes*') ? 'router-link-exact-active router-link-active' : '' }}">
            Athletes
        </a>
    </li>
    <li class="leading-wide mb-4 text-sm">
        <a href="/admin/resources/tryouts" class="text-white ml-8 no-underline {{ request()->is('admin/resources/tryouts*') ? 'router-link-exact-active router-link-active' : '' }}">
            Tryouts
        </a>
    </li>
    <li class="leading-wide mb-4 text-sm">
        <a href="/admin/resources/swim-team-levels" class="text-white ml-8 no-underline {{ request()->is('admin/resources/swim-team-levels*') ? 'router-link-exact-active router-link-active' : '' }}">
            Levels
        </a>
    </li>
    <li class="leading-wide mb-4 text-sm">
        <a href="/admin/resources/swim-team-seasons" class="text-white ml-8 no-underline {{ request()->is('admin/resources/swim-team-seasons*') ? 'router-link-exact-active router-link-active' : '' }}">
            Seasons
        </a>
    </li>
    <li class="leading-wide mb-4 text-sm">
        <a href="/admin/resources/swim-team-coaches" class="text-white ml-8 no-underline {{ request()->is('admin/resources/swim-team-coaches*') ? 'router-link-exact-active router-link-active' : '' }}">
            Coaches
        </a>
    </li>
    <li class="leading-wide mb-4 text-sm">
        <a href="/admin/resources/shirt-sizes" class="text-white ml-8 no-underline {{ request()->is('admin/resources/shirt-sizes*') ? 'router-link-exact-active router-link-active' : '' }}">
            Shirt Sizes
        </a>
    </li>
</ul>