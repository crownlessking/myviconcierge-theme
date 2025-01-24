
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

  /**
   * Indicate whether the restaurant is currently close, open, or
   * is about to be open or close in less than 30 minutes.
   */
  function getRestaurantStatus(businessHours = []) {
    const now = new Date();
    const currentDay = now.toLocaleString('en-US', { weekday: 'long' });
    const todayHours = businessHours.find(day => day.day === currentDay.toLowerCase());console.log('todayHours', todayHours);
    const previousDayName = new Date(now.setDate(now.getDate() - 1)).toLocaleString('en-US', { weekday: 'long' }).toLowerCase();
    const previousDayHours = businessHours.find(day => day.day === previousDayName);console.log('previousDayHours', previousDayHours);

    if ((!previousDayHours || !previousDayHours.open || !previousDayHours.close)
      && (!todayHours || !todayHours.open || !todayHours.close)
    ) {
      return {
        status: 'closed',
        className: 'status themed-bh-status-closed'
      };
    }
  
    const statusObj = getBhStatusMsg(previousDayHours, todayHours);

    return statusObj;
  }

  /** Get business hours status message */
  function getBhStatusMsg(previousDay, today) {
    const now = new Date();
    const previousDayClose = parseTime(previousDay.close);
    const todayOpen = parseTime(today.open);
    const todayClose = parseTime(today.close);
    const currentTime = now.getHours() * 60 + now.getMinutes();
    const previousDayOpen = parseTime(previousDay.open);
    const $12am = parseTime('24:00');

    // UNUSUAL SCHEDULE
    if (!isNaN(todayOpen) && !isNaN(todayClose) && todayOpen > todayClose) {

      // currently close but will open eventually
      if (todayOpen > currentTime) {
        return bhStatus('opening', todayOpen - currentTime);

      // currently open
      } else if (todayOpen < currentTime && currentTime < $12am) {
        return bhStatus('open');
      }
    }

    // UNUSUAL SCHEDULE (open from previous day)
    else if (!isNaN(previousDayOpen)
      && !isNaN(previousDayClose)
      && previousDayOpen > previousDayClose
      && currentTime < previousDayClose
    ) {
      return bhStatus('closing', previousDayClose - currentTime);

    // NORMAL SCHEDULE
    } else if (todayOpen < todayClose) {

      // currently closed but will open eventually
      if (currentTime < todayOpen) {
        return bhStatus('opening', todayOpen - currentTime);

      // currently open but will close eventually
      } else if (todayOpen < currentTime && currentTime < todayClose) { 
        return bhStatus('open', todayClose - currentTime);
      }
    } else {
      return {
        status: 'closed',
        className: 'status themed-bh-status-closed'
      };
    }
  }

  /**
   * Convert 24h time format to the integer equivalent for computing purposes.
   */
  function parseTime(timeStr) {
    const [hours, minutes] = timeStr.split(':').map(Number);
    return hours * 60 + minutes;
  }

  /** Get status object. */
  function bhStatus(type, timeLeft = 31) {
    switch (type) {
      case 'opening':
        if (timeLeft > 30) { break; }
        if (0 < timeLeft && timeLeft <= 30) {
          return {
            status: `opening in ${timeLeft}`,
            className: 'status themed-bh-status-opening'
          };
        }
      case 'open':
        if (timeLeft > 30) {
          return {
            status: 'open',
            className: 'status themed-bh-status-open'
          };
        }
      case 'closing':
        if (0 < timeLeft && timeLeft <= 30) {
          return {
            status: `closing in ${timeLeft} minute(s)`,
            className: 'status themed-bh-status-closing'
          };
        }
      default:
      case 'closed':
    }
    return {
      status: 'closed',
      className: 'status themed-bh-status-closed'
    };
  }

  // Toggle navigation links in mobile view
  document.getElementById('navbar-toggler').addEventListener('click', function() {
    var collapse = document.getElementById('navbar-collapse');
    collapse.classList.toggle('hidden');
  });  

  // Prevents website layout from breaking if the wordpress admin bar is displayed.
  document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('wpadminbar')) { // if admin bar visible
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

  // Displays business hours status on restaurant page
  document.addEventListener('DOMContentLoaded', function() {
    if (typeof businessHours !== 'undefined') {
      const statusElement = document.getElementById('bh-status');
      const statusObj = getRestaurantStatus(businessHours);
      statusElement.textContent = statusObj.status;
      statusElement.className = statusObj.className;
    } else {
      console.error('businessHours is not defined');
    }
  });

})();