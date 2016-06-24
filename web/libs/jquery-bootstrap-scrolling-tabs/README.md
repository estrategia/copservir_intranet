jquery-bootstrap-scrolling-tabs
================================

jQuery plugin for making Bootstrap 3 Tabs scroll horizontally rather than wrap.

Here's what they look like:

![](https://raw.githubusercontent.com/mikejacobson/jquery-bootstrap-scrolling-tabs/master/st-screenshot1.png)


And here are plunks showing them working with:

* <a href="http://plnkr.co/edit/thyD0grCxIjyU4PoTt4x?p=preview" target="_blank">HTML-defined Tabs</a>
* <a href="http://plnkr.co/edit/MWBjLnTvJeetjU3NEimg?p=preview" target="_blank">Data-driven Tabs</a>

Use Cases
---------
* [Use Case #1: Wrap HTML-defined Tabs](#uc1)
* [Use Case #2: Create Data-driven Tabs](#uc2)



Optional Features
-----------------
There is also an optional feature available:
* [Force Scroll to Tab Edge](#ft1)



Usage
-----
1. Download it or install it using bower: `bower install jquery-bootstrap-scrolling-tabs` or npm: `npm install jquery-bootstrap-scrolling-tabs`
2. Include `jquery.scrolling-tabs.min.css` (or `jquery.scrolling-tabs.css`) on your page *after* Bootstrap's CSS
3. Include `jquery.scrolling-tabs.min.js` (or `jquery.scrolling-tabs.js`) on your page (make sure that jQuery is included before it, of course)



Overview
--------
If you're using Bootstrap Tabs (`nav-tabs`) and you don't want them to wrap if the page is too narrow to accommodate them all in one row, you can use this plugin to keep them in a row that scrolls horizontally without a scrollbar.

It adjusts itself on window resize (debounced to prevent resize event wackiness), so if the window is widened enough to accommodate all tabs, scrolling will deactivate and the scroll arrows will disappear. (And, of course, vice versa if the window is narrowed.)


Use Cases
---------
#### <a id="uc1"></a>Use Case #1: HTML-defined Tabs

If your `nav-tabs` markup looks like this:
```html
<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
  <li role="presentation" class="active"><a href="#tab1" role="tab" data-toggle="tab">Tab Number 1</a></li>
  <li role="presentation"><a href="#tab2" role="tab" data-toggle="tab">Tab Number 2</a></li>
  <li role="presentation"><a href="#tab3" role="tab" data-toggle="tab">Tab Number 3</a></li>
  <li role="presentation"><a href="#tab4" role="tab" data-toggle="tab">Tab Number 4</a></li>
  <li role="presentation"><a href="#tab5" role="tab" data-toggle="tab">Tab Number 5</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div role="tabpanel" class="tab-pane active" id="tab1">Tab 1 content...</div>
  <div role="tabpanel" class="tab-pane" id="tab2">Tab 2 content...</div>
  <div role="tabpanel" class="tab-pane" id="tab3">Tab 3 content...</div>
  <div role="tabpanel" class="tab-pane" id="tab4">Tab 4 content...</div>
  <div role="tabpanel" class="tab-pane" id="tab5">Tab 5 content...</div>
</div>
```

you can wrap the tabs in the scroller like this:
```javascript
$('.nav-tabs').scrollingTabs();
```

##### scrollToTabEdge Option

You can also pass in the `scrollToTabEdge` option:
```javascript
$('.nav-tabs').scrollingTabs({
  scrollToTabEdge: true  
});
```
This will force the scrolling to always end with a tab edge aligned with the left scroll arrow. More details [here](#ft1).


#### <a id="uc2"></a>Use Case #2: Data-driven Tabs

If your tabs are data-driven rather than defined in your markup, you just need to pass your tabs array to the plugin and it will generate the tab elements for you.

So your tabs data should look something like this (note that the tab titles can contain HTML):
```javascript
var myTabs = [
  { paneId: 'tab01', title: 'Tab <em>1</em> of 12', content: 'Tab Number 1 Content', active: true, disabled: false },
  { paneId: 'tab02', title: 'Tab 2 of 12', content: 'Tab Number 2 Content', active: false, disabled: false },
  { paneId: 'tab03', title: 'Tab 3 of 12', content: 'Tab Number 3 Content', active: false, disabled: false },
  { paneId: 'tab04', title: 'Tab 4 of 12', content: 'Tab Number 4 Content', active: false, disabled: false },
  { paneId: 'tab05', title: 'Tab 5 of 12', content: 'Tab Number 5 Content', active: false, disabled: false }
];

```

You would then need a target element to append the tabs and panes to, like this:

```html
<!-- build .nav-tabs and .tab-content in here -->
<div id="tabs-inside-here"></div>
```


Then just call the plugin on that element, passing a settings object with a `tabs` property pointing to your tabs array:

```javascript
$('#tabs-inside-here').scrollingTabs({
  tabs: myTabs
});

```

##### Required Tab Data Properties

Each tab object in the array must have a property for
* the tab title (text or HTML)
* the ID of its target pane (text)
* its active state (bool)

Optionally, it can also have a boolean for its `disabled` state.


##### 'Content' Property for Tab Panes

If you want the plugin to generate the tab panes also, include a `content` property on the tab objects.

If your tab objects have a `content` property but you *don't* want the plugin to generate the panes, pass in plugin option `ignoreTabPanes: true` when calling the plugin.

```javascript
$('#tabs-inside-here').scrollingTabs({
  tabs: myTabs,
  ignoreTabPanes: true
});

```

##### Custom Tab Data Property Names

By default, the plugin assumes those properties will be named `title`, `paneId`, `active`, `disabled`, and `content`, but if you want to use different property names, you can pass your property names in as properties on the settings object:

```javascript
$('#tabs-inside-here').scrollingTabs({
  tabs: myTabs, // required,
  propTitle: 'myTitle', // required if not 'title'
  propPaneId: 'myPaneId', // required if not 'paneId'
  propActive: 'myActive', // required if not 'active'
  propDisabled: 'myDisabled', // required if not 'disabled'
  propContent: 'myContent' // required if not 'content'
});
```javascript



So, for example, if your tab objects used the property name `label` for their titles instead of `title`, you would need to pass property `propTitle: 'label'` in your settings object.

```javascript
$('#tabs-inside-here').scrollingTabs({
  tabs: myTabs,
  propTitle: 'label'
});

```

##### scrollToTabEdge Option

And just like in Use Case #1, you can also pass in the `scrollToTabEdge` option if you want to force the scrolling to always end with a tab edge aligned with the left scroll arrow:

```javascript
$('#tabs-inside-here').scrollingTabs({
  tabs: myTabs,
  scrollToTabEdge: true  
});
```


##### Refreshing after Tab Data Change

On `tabs` data change, just call the plugin's `refresh` method to refresh the tabs on the page:
```javascript
$('#tabs-inside-here').scrollingTabs('refresh');
```


##### forceActiveTab Option

On `tabs` data change, if you want the active tab to be set based on the updated tabs data (i.e., you want to override the current active tab setting selected by the user), for example, if you added a new tab and you want it to be the active tab, pass the `forceActiveTab` flag on refresh:
```javascript
$('#tabs-inside-here').scrollingTabs('refresh', {
  forceActiveTab: true
});
```

#### <a id="ft1"></a>Force Scroll to Tab Edge

If you want to ensure the scrolling always ends with a tab edge aligned with the left scroll arrow so there won't be a partially hidden tab, pass in option `scrollToTabEdge: true`:

```javascript
$('#tabs-inside-here').scrollingTabs({
  tabs: myTabs,
  scrollToTabEdge: true  
});
```

There's no way to guarantee the left *and* right edges will be full tabs because that's dependent on the the width of the tabs and the window. So this just makes sure the left side will be a full tab.


#### Setting Defaults
Any options that can be passed into the plugin can also be set on the plugin's `defaults` object:
```javascript
$.fn.scrollingTabs.defaults.tabs = myTabs;
$.fn.scrollingTabs.defaults.forceActiveTab = true;
$.fn.scrollingTabs.defaults.scrollToTabEdge = true;
```

#### Destroying the Plugin
To destroy the plugin, call its `destroy` method:
```javascript
$('#tabs-inside-here').scrollingTabs('destroy');
```

If you were wrapping markup, the markup will be restored; if your tabs were data-driven, the tabs will be destroyed along with the plugin.


License
-------
MIT License.
