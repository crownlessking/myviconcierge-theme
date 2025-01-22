
(function () {

  var windowVisible = true;
  var panelVisible = false;
  var btnShowMap;
  var openContentLink;
  var mapPanelToggleSwitch;
  
  function fontAwesomeAvailable() {
    // Check if the Font Awesome stylesheet is loaded
    const faStylesheet = Array.from(document.styleSheets).some(sheet => sheet.href && sheet.href.includes('font-awesome'));
    if (!faStylesheet) {
      return false;
    }

    // Check if Font Awesome icon is rendered correctly
    const testElement = document.createElement('i');
    testElement.className = 'fas fa-check';
    document.body.appendChild(testElement);
    const isRendered = window.getComputedStyle(testElement)
      .getPropertyValue('font-family')
      .includes('Font Awesome');
    document.body.removeChild(testElement);
    return isRendered;
  }

  function removeChildren(node) {
    while (node.firstChild) {
      node.removeChild(node.firstChild);
    }
  }

  function setNodeChildren(parentNode, childNode) {
    removeChildren(parentNode);
    parentNode.appendChild(childNode);
  }

  function writeText(node, text) {
    setNodeChildren(node, document.createTextNode(text));
  }

  const updateMapPanelVisibilityFa = (e) => {
    const a = e.target.parentNode;
    if (a.id !== 'switch') { return; }
    const mapPanelScrollable = document.getElementById('map-panel-scrollable');
    const i = document.createElement('i');
    if (a.dataset.state ==='hidden') {
      mapPanelScrollable.style.display = '';
      a.dataset.state = 'shown';
      i.className = 'fa-solid fa-toggle-on';
    } else {
      mapPanelScrollable.style.display= 'none';
      a.dataset.state = 'hidden';
      i.className = 'fa-solid fa-toggle-off';
    }
    setNodeChildren(a, i);
  };

  function updateMapPanelVisibility(e) {
    var a = e.target; // document.getElementById('switch');
    var mapPanelScrollable = document.getElementById('map-panel-scrollable');

    if (a.dataset.state === 'hidden') {
      mapPanelScrollable.style.display = '';
      a.dataset.state = 'shown';
      writeText(a, '|hide|');
    } else {
      mapPanelScrollable.style.display = 'none';
      a.dataset.state = 'hidden';
      writeText(a, '|show|');
    }
  }

  function mvic_toggle_panel() {
    document.getElementById('map-panel').style.display = panelVisible ? '' : 'none';
  }

  function mvic_animate_window(a) {
    var b = '-' + jQuery(window).height() + 'px';
    a ? jQuery('#main').animate({top:'0'},'fast') : jQuery('#main').animate({top:b},'fast',mvic_toggle_panel);
  }

  function showContent(a) {
    if(windowVisible!==a) {
      windowVisible = a;
      panelVisible = !a;
      !panelVisible && mvic_toggle_panel();
      mvic_animate_window(a);
    }
  }

  function setMapPanelToggleSwitch() {
    const div = document.createElement('div');

    const openContentIcon = document.createElement('a');
    openContentIcon.href = '#';
    const backIcon = document.createElement('i');
    backIcon.className = 'fa-solid fa-arrow-left';
    openContentIcon.appendChild(backIcon);
    openContentIcon.onclick = () => showContent(true);
    div.appendChild(openContentIcon);
    div.appendChild(document.createTextNode('\u00a0\u00a0'));

    mapPanelToggleSwitch = document.createElement('a');
    div.id = div.className = 'switch-div';
    mapPanelToggleSwitch.id = 'switch';
    mapPanelToggleSwitch.href = '#';
    mapPanelToggleSwitch.title = 'Toggle panel visibility';
    mapPanelToggleSwitch.dataset.state = 'shown';
    mapPanelToggleSwitch.appendChild(document.createTextNode('|hide|'));
    mapPanelToggleSwitch.onclick = updateMapPanelVisibility;
    div.appendChild(mapPanelToggleSwitch);

    document.getElementById('map-panel-header').appendChild(div);
  }

  setMapPanelToggleSwitch();
  document.addEventListener('DOMContentLoaded', () => {
    if (fontAwesomeAvailable()) {
      const i = document.createElement('i');
      if (mapPanelToggleSwitch.dataset.state ==='hidden') {
        i.className = 'fa-solid fa-toggle-off';
      } else {
        i.className = 'fa-solid fa-toggle-on';
      }
      setNodeChildren(mapPanelToggleSwitch, i);
      mapPanelToggleSwitch.onclick = updateMapPanelVisibilityFa;
    } else {
      console.log('Font Awesome is not available.');
    }
  });
  mvic_toggle_panel();

  btnShowMap = document.getElementById('close-button');
  openContentLink = document.getElementById('mvic-ui-open-content');

  if (btnShowMap) {
    btnShowMap.onclick = function() {
      showContent(false);
    }
  }

  if (openContentLink) {
    openContentLink.onclick = function() {
      showContent(true);
    }
  }

  if (!windowVisible) {
    document.getElementById('main').style.top = '-' + jQuery(window).height() + 'px';
  } else {
    mvic_toggle_panel();
  }

  document.getElementById('navbar-toggler').addEventListener('click', function() {
    var collapse = document.getElementById('navbar-collapse');
    collapse.classList.toggle('hidden');
  });  

  // Prevents website layout from breaking if the wordpress admin bar is displayed.
  document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('wpadminbar')) { // is admin bar visible
      console.log('Admin bar is visible');
      // Trigger your JavaScript functions here
      document.getElementById('main').classList.add('overlay-active');
      document.getElementsByTagName('body')[0].classList.add('overlay-active');
      document.getElementsByTagName('html')[0].classList.add('overlay-active');
    } else {
      console.log('Admin bar is not visible');
      document.getElementById('main').classList.remove('overlay-active');
      document.getElementsByTagName('body')[0].classList.remove('overlay-active');
      document.getElementsByTagName('html')[0].classList.remove('overlay-active');
    }
  });

  /**
   * On the restaurant page, make the restaurant data available as an object. e.g.
   * 
   * ```js
   * const restaurantData = {
   *   name: <restaurant_name>,
   *   businessHours: [
   *     { day: Sun, open: '', close: '', meal: '' }
   *   ]
   * }
   * ```
   * 
   * Use that data to indicate whether the restaurant is currently close, open, or
   * is about to be open or close in less than 30 minutes.
   */
  function getRestaurantStatus(restaurantData) {
    const now = new Date();
    const currentDay = now.toLocaleString('en-US', { weekday: 'short' });
    const currentTime = now.getHours() * 60 + now.getMinutes();

    const todayHours = restaurantData.businessHours.find(day => day.day === currentDay);

    if (!todayHours || !todayHours.open || !todayHours.close) {
      return 'closed';
    }

    const openTime = parseTime(todayHours.open);
    const closeTime = parseTime(todayHours.close);

    if (currentTime < openTime) {
      return 'closed';
    } else if (currentTime >= openTime && currentTime < closeTime) {
      if (closeTime - currentTime <= 30) {
        return 'closing soon';
      }
      switch (todayHours.meal) {
        case 'Breakfast':
          return 'open for breakfast';
        case 'Brunch':
          return 'open for brunch';
        case 'Dinner':
          return 'open for dinner';
        default:
          return 'open';
      }
    } else if (openTime - currentTime <= 30) {
      return 'opening soon';
    } else if (currentTime >= closeTime && currentTime < closeTime + 30) {
      return 'just closed';
    } else {
      return 'closed';
    }
  }

  function parseTime(timeStr) {
    const [hours, minutes] = timeStr.split(':').map(Number);
    return hours * 60 + minutes;
  }

  // Example usage:
  const restaurantData = {
    name: 'Example Restaurant',
    businessHours: [
      { day: 'Sun', open: '10:00', close: '22:00', meal: 'Lunch' },
      { day: 'Mon', open: '10:00', close: '22:00', meal: 'Lunch' },
      // Add other days as needed
    ]
  };

  console.log(getRestaurantStatus(restaurantData));
})();