<nav class="container" role="category_navigation" id="navigation_category" ng-show="$state.is('index')">
    <ul class="nav nav-pills nav-justified text-center font-orbitron-500">
        <li role="category" ng-class="{ active: $state.is('index') }">
            <a ui-sref="index">ALL</a>
        </li>
        <li role="category">
            <a href="">WEB DEVELOPMENT</a>
        </li>
        <li role="category">
            <a href="">GRAPHIC DESIGN</a>
        </li>
        <li role="category">
            <a href="">ARTWORK</a>
        </li>
    </ul>
</nav>