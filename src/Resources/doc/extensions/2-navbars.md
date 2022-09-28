Generating a Navbar
===================

# Navbar and Menus Extension

We make use of KnpMenu and KnpMenuBundle in order to help in the generation of
Bootstrap Menus and navbars. We also provide a pass-through function for `knp_menu_render`,
`networking_bootstrap_menu` which sets some default options for the menus.

To learn how to create menus with KnpMenuBundle, [please check their documentation
before continuing.](https://github.com/KnpLabs/KnpMenuBundle)

## Activate the extension

To load the navbar extensions (Twig Extension, and KnpMenu Extension) just add the
following in your config.yml. **You need to activate this extension in order
to use the Twig function and KnpMenu Navbar extension.**

``` yaml
networking_bootstrap:
    menu: ~
```

## Auto bootstrap menu

By adding "automenu" : "navbar" or "automenu": "pills" you can use mopa_boostrap_menu to generate bootstrap3 markup even if your underlying menu doesnt have special menu options or class attributes etc

```
{{ networking_bootstrap_menu('mymenu', {'automenu': 'navbar'}) }}
```

See below for Special Menu Options, the automenu just sets these based on the root item you provide, and CHANGES the attributes of the children accordingly in a magic way.

If you need control yourself, just ommit automenu setting and do whatever you need

## Special Menu Options

We register a new menu extension so you have options available to you:

- navbar (top and/or bottom)(static or fixed)
- pills
- stacked
- dropdown-header
- dropdown
- caret
- pull-right
- icon
- badge

Example Usage:

``` php
class Builder
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        // Menu will be a navbar menu anchored to right
        $menu = $factory->createItem('root', array(
            'navbar' => true,
            'pull-right' => true,
        ));

        // Add a regular child with an icon, icon- is prepended automatically
        $layout = $menu->addChild('Layout', array(
            'icon' => 'home',
            'route' => 'networking_bootstrap_layout_example',
        ));

        // Add a regular child with a badge and icon, icon- is prepended automatically
        // If you pass false to badge it will not show
        // This can be useful for 'badge' => $badgeData,  where $badgeData is a DB result (message or notification counts)
        // badge-class can be used to style the badge
        $layout = $menu->addChild('Layout', array(
            'icon' => 'home',
            'badge' => '7',
            'badge-class' => 'menu-badge',
            'route' => 'networking_bootstrap_layout_example',
        ));

        // Create a dropdown with a caret
        $dropdown = $menu->addChild('Forms', array(
            'dropdown' => true,
            'caret' => true,
        ));

        // Create a dropdown header
        $dropdown->addChild('Some Header', array('dropdown-header' => true));
        $dropdown->addChild('Example 1', array('route' => 'some_route'));

        return $menu;
    }
}
```

## Rendering a Navbar

Navbars are rendered by using the Twig `embed` tag. This is similar to include
in that it includes the template, but it also lets your override blocks in that
template.

It is not necessary to use these templates, they are just simply there to provide
you with a shortcut to creating Navbars more quickly. You can always extend these
templates and embed your own templates instead.

Top and Bottom navbar's supported on same page by giving each a unique navbar_id.

You can create your menu as a service or you can use the controller notation.

Here is a sample Navbar:

``` jinja
{% embed '@NetworkingBootstrap/Navbar/navbar.html.twig' with { fixedTop: true, staticTop: false, fixedBottom: false, staticBottom: false, inverse: true, id: mainTop } %}
    {% block brand %}
        <a class="navbar-brand" href="#">Mopa Bootstrap</a>
    {% endblock %}

    {% block menu %}
        {{ networking_bootstrap_menu('AcmeBundle:Builder:mainMenu') }}
        {{ networking_bootstrap_menu('menuAlias') }}
    {% endblock %}
{% endembed %}
```

## Change the Navbar template

Maybe you have multiple Navbars that you would like to keep the brand consistent,
or one of the menus is always the same. You can do this by extending the Navbar
template and then embedding it:

``` jinja
{# @Acme/Navbar/navbar.html.twig #}
{% extends '@NetworkingBootstrap/Navbar/navbar.html.twig' %}

{% block menu %}
    {{ networking_bootstrap_menu('AcmeBundle:Builder:mainMenu') }}
{% endblock %}

{% block brand %}
    <a class="navbar-brand" href="{{ path('dashboard') }}">Acme</a>
{% endblock %}
```

Now embed that in your template instead:

``` jinja
{% embed '@Acme/Navbar/navbar.html.twig' with { fixedTop: true } %}
    {% block menu %}
        {{ parent() }}
        {{ networking_bootstrap_menu('AcmeBundle:Builder:rightMenu') }}
    {% endblock %}
{% endembed %}
```

---

<< [Using Icons](1-icons.md) | [Bootstrap Extras (Initializr)](3-initializr.md) >>
