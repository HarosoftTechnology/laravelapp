<?php

namespace App\Libraries;

// Helper to get the current URL.
if (!function_exists('current_url')) {
    function current_url()
    {
        return request()->url();
    }
}

// Helper to determine the current page alias.
// You can adjust this logic depending on how you want to figure out the active menu item.
if (!function_exists('getCurrentPageAlias')) {
    function getCurrentPageAlias()
    {
        // Implement your logic for determining the current page alias.
        // For a basic implementation, you could return an empty string.
        return '';
    }
}

class Menu
{
    /*-------------------------------------------------
     * Instance Properties (per menu item)
     *-------------------------------------------------*/
    public $id;
    public $title;
    public $link;
    public $icon = '';
    public $badgecount = '';
    public $badge_bgcolor = '';
    public $ajax = true;  // Determines if AJAX navigation is enabled.
    public $tab = false;  // Determines if the link should open in a new tab.
    public $children = []; // Array to hold child menus.
    public $active = false; // Indicates active status.

    /*-------------------------------------------------
     * Static Properties (global menu management)
     *-------------------------------------------------*/
    protected static $menus = [];          // Menus stored by location (e.g., "main-menu").
    protected static $menuLocations = [];  // Menu location descriptions.
    protected static $availableMenus = []; // Additional available menus.

    /**
     * Constructor.
     *
     * @param string      $title         The display title for the menu item.
     * @param string|null $link          The URL (defaults to "#" if null).
     * @param string      $id            Optional unique identifier.
     * @param string      $icon          Optional icon CSS class.
     * @param string      $badgecount    Optional badge count.
     * @param string      $badge_bgcolor Optional badge background color.
     * @param bool        $ajaxify       Optional flag for AJAX navigation.
     * @param bool        $open_new_tab  Optional flag to open the link in a new tab.
     */
    public function __construct(
        string $title, 
        ?string $link = "#", 
        string $id = "", 
        string $icon = "", 
        string $badgecount = "", 
        string $badge_bgcolor = "", 
        bool $ajaxify = true, 
        bool $open_new_tab = false
    ) {
        $this->title         = $title;
        $this->link          = $link ?? "#";
        $this->id            = $id;
        $this->icon          = $icon;
        $this->badgecount    = $badgecount;
        $this->badge_bgcolor = $badge_bgcolor;
        $this->ajax          = $ajaxify;
        $this->tab           = $open_new_tab;
    }

    /*=================================================
     * Instance (Non-static) Methods
     *=================================================*/

    /**
     * Add a submenu (child item) to this menu item.
     *
     * @param string      $title      The submenu title.
     * @param string|null $link       The submenu link.
     * @param string|null $alias      Optional alias for a unique key.
     * @param array       $attributes Array with extra attributes: 'icon', 'badgecount', 'badge_bgcolor', 'ajax', 'tab'.
     * @return Menu The newly created submenu item.
     */
    public function addMenu(string $title, ?string $link, ?string $alias = null, array $attributes = []): Menu
    {
        $link = $link ?? "#";

        $icon          = $attributes['icon'] ?? '';
        $badgecount    = $attributes['badgecount'] ?? '';
        $badge_bgcolor = $attributes['badge_bgcolor'] ?? '';
        $ajaxify       = $attributes['ajax'] ?? true;
        $open_new_tab  = $attributes['tab'] ?? false;

        $child = new Menu($title, $link, $alias ?? uniqid(), $icon, $badgecount, $badge_bgcolor, $ajaxify, $open_new_tab);

        // Use the alias (or generate a unique ID) as the key for children.
        $key = $alias ?? uniqid();
        $this->children[$key] = $child;
        return $child;
    }

    /**
     * Check recursively if this menu or any of its children is active.
     *
     * @param string|null $currentUrl Current URL string for comparison.
     * @return bool True if this item or any child is active.
     */
    public function isActive(?string $currentUrl = null): bool
    {
        if ($currentUrl === null) {
            $currentUrl = current_url();
        }

        if ($this->link === $currentUrl) {
            $this->active = true;
        }

        foreach ($this->children as $child) {
            if ($child->isActive($currentUrl)) {
                $this->active = true;
            }
        }
        return $this->active;
    }

    /**
     * Explicitly set the active state of the menu item.
     *
     * @param bool $value Active state.
     * @return Menu
     */
    public function setActive(bool $value = true): Menu
    {
        $this->active = $value;
        return $this;
    }

    /**
     * Recursively search among children for a menu item with the given ID.
     *
     * @param string $id The ID or alias.
     * @return Menu The found menu item, or a new empty Menu if not found.
     */
    public function findMenu(string $id): Menu
    {
        foreach ($this->children as $child) {
            if ($child->id === $id) {
                return $child;
            }
            $found = $child->findMenu($id);
            if ($found->title !== '') {
                return $found;
            }
        }
        return new Menu('');
    }

    /**
     * Checks if this menu item has any child menus.
     *
     * @return bool True if there are child menus.
     */
    public function hasChildren(): bool
    {
        return !empty($this->children);
    }

    /**
     * Recursively render this menu and its children as an HTML <li> element.
     *
     * @return string HTML markup.
     */
    public function render(): string
    {
        $activeClass = $this->active ? 'active' : '';
        $target = $this->tab ? ' target="_blank"' : '';
        $html = "<li class='{$activeClass}'>";
        $html .= "<a href='{$this->link}'{$target}>";
        if ($this->icon) {
            $html .= "<i class='{$this->icon}'></i> ";
        }
        $html .= "{$this->title}";
        if ($this->badgecount !== '') {
            $html .= " <span class='badge' style='background-color: {$this->badge_bgcolor};'>{$this->badgecount}</span>";
        }
        $html .= "</a>";

        if ($this->hasChildren()){
            $html .= "<ul>";
            foreach ($this->children as $child) {
                $html .= $child->render();
            }
            $html .= "</ul>";
        }
        $html .= "</li>";
        return $html;
    }

    /*=================================================
     * Static Methods for Global Menu Management
     *=================================================*/

    /**
     * Add a menu item to a given location.
     *
     * @param string $location Menu location (e.g., 'main-menu').
     * @param array  $data     Array containing 'id', 'title', 'link', etc.
     * @param string|null $alias Optional alias.
     */
    public static function addMenuItem(string $location, array $data, ?string $alias = null): void
    {
        if (!isset(self::$menus[$location])) {
            self::$menus[$location] = [];
        }
        $key = $alias ?? ($data['id'] ?? uniqid());
        $menuItem = new Menu(
            $data['title']         ?? '',
            $data['link']          ?? '#',
            $data['id']            ?? $key,
            $data['icon']          ?? '',
            $data['badgecount']    ?? '',
            $data['badge_bgcolor'] ?? '',
            $data['ajax']          ?? true,
            $data['tab']           ?? false
        );
        self::$menus[$location][$key] = $menuItem;
    }

    /**
     * Retrieve a menu item by location and optionally by ID.
     *
     * @param string      $location
     * @param string|null $id
     * @return Menu
     */
    public static function getMenu(string $location, ?string $id = null): Menu
    {
        if (isset(self::$menus[$location])) {
            $id = $id ?: getCurrentPageAlias();
            if (isset(self::$menus[$location][$id])) {
                return self::$menus[$location][$id];
            }
        }
        return new Menu('');
    }

    /**
     * Define a menu location with a description.
     *
     * @param string $location    The menu identifier.
     * @param string $description A human-readable description.
     */
    public static function addLocation(string $location, string $description): void
    {
        self::$menuLocations[$location] = $description;
    }

    /**
     * Register an available menu (for additional configurations).
     *
     * @param string $id    Identifier.
     * @param string $link  Typically a URL or shortcut.
     * @param mixed  $other Optional extra info.
     */
    public static function addAvailableMenu(string $id, string $link, $other = null): void
    {
        self::$availableMenus[$id] = [
            'link'  => $link,
            'other' => $other,
        ];
    }

    /**
     * Retrieve all menu items for a given location.
     *
     * @param string $location
     * @return array
     */
    public static function getAllMenus(string $location): array
    {
        return self::$menus[$location] ?? [];
    }

    /**
     * Retrieve all menus for debugging or further processing.
     *
     * @return array
     */
    public static function getMenus(): array
    {
        return self::$menus;
    }
}
