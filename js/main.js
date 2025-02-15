
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
    if (a) {
      jQuery('#main').css('display', '');
    }
    a ? jQuery('#articulated').animate({top:'0'},'fast')
      : jQuery('#articulated').animate({top:b},'fast',() => {
        jQuery('#main').css('display', 'none');
        mvic_toggle_panel();
      });
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
    btnShowMap.addEventListener('click', function() {
      showContent(false);
    });
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
   * Get restaurant business hours status.
   */
  function getRestaurantBusinessHoursStatus(businessHours = []) {
    const now = new Date();
    const currentDay = now.toLocaleString('en-US', { weekday: 'long' });
    const currentTime = now.getHours() * 60 + now.getMinutes();
    const accCurrentTime = 1440 * now.getDay() + currentTime;
    let unusualHours = null;
    let statusObj = getStatusObj('close');

    for (let i = 0; i < businessHours.length; i++) {
      const hours = businessHours[i];

      if (hours.day === currentDay.toLowerCase()) {
        if (unusualHours && unusualHours.day === getPreviousDay(hours.day)) {
          statusObj = getUnusualStatusSelection(accCurrentTime, unusualHours);
          break;
        } else {
          statusObj = getStatusSelection(accCurrentTime, hours);
          break;
        }
      }

      // Store current hours if they are unusual.
      if (hours.day && hours.open && hours.close && hours.open > hours.close) {
        unusualHours = hours;
      } else {
        unusualHours = null;
      }
    }
    return statusObj;
  }

  /**
   * @param {string} day
   */
  function getPreviousDay(day) {
    const days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
    const index = days.indexOf(day.toLowerCase());
    return days[(index - 1 + days.length) % days.length];
  }

  function getStatusSelection(accCurrentTime, hours = getDefaultHours()) {
    const now = new Date();
    const dayInt = now.getDay();
    let statusObj = getStatusObj('close');

    if (hours.open) {
      const open = parseTime(hours.open);
      const accOpen = 1440 * dayInt + open;
      if (accCurrentTime < accOpen) {
        statusObj = getStatusObj('opening', accOpen - accCurrentTime);
        return statusObj;
      }
      if (hours.close) {
        const close = parseTime(hours.close);
        let accClose;
        if (open < close) { // normal schedule
          accClose = 1440 * dayInt + close;
          if (accCurrentTime < accClose) {
            statusObj = getStatusObj('open', accClose - accCurrentTime);
            return statusObj;
          }
        } else { // unusual schedule
          const nextDayInt = (dayInt + 1) % 7;
          const unAccClose = 1440 * nextDayInt + close;
          if (accCurrentTime < unAccClose) {
            statusObj = getStatusObj('open', unAccClose - accCurrentTime);
            return statusObj;
          }
        }
      }
    }
    return statusObj;
  }

  function getUnusualStatusSelection(accCurrentTime, unusualHours = getDefaultHours()) {
    const now = new Date();
    const dayInt = now.getDay();
    let statusObj = getStatusObj('close');

    if (unusualHours.close) {
      const close = parseTime(unusualHours.close);
      const accClose = 1440 * dayInt + close;
      if (accClose > accCurrentTime) {
        statusObj = getStatusObj('closing', accClose - accCurrentTime);
        return statusObj;
      }
    }
    return statusObj;
  }

  /**
   * Convert 24h time format to the integer equivalent for computing purposes.
   */
  function parseTime(timeStr) {
    const [hours, minutes] = timeStr.split(':').map(Number);
    return hours * 60 + minutes;
  }

  function getDefaultHours() {
    return {
      day: '',
      open: '',
      close: ''
    }
  }

  /** Get restaurant business hours status object. */
  function getStatusObj(type, timeLeft = 31) {
    switch (type) {
      case 'opening':
        if (timeLeft > 30) { break; }
        if (0 < timeLeft && timeLeft <= 30) {
          return {
            status: `opening in ${timeLeft} minute(s)`,
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

  let navigationHeight = 0;
  let wpadminbarHeight = 0;

  // Toggle navigation links in mobile view
  document.getElementById('navbar-toggler').addEventListener('click', function() {
    var collapse = document.getElementById('navbar-collapse');
    const toggledClass = 'navbar-show';
    const main = document.getElementById('main');

    if (collapse.classList.contains('hidden')) {
      collapse.classList.remove('hidden');

      // Force reflow to ensure the transition happens
      void collapse.offsetWidth;
      void main.offsetWidth;

      collapse.classList.add('show');
      main.classList.add(toggledClass);

      setTimeout(adjustArticulatedMaxHeights, 100);
    } else {
      collapse.classList.remove('show');
      // Wait for the transition to complete before adding the hidden class
      collapse.addEventListener('transitionend', function() {
        collapse.classList.add('hidden');
        main.classList.remove(toggledClass);

        restoreArticulatedMaxHeights();
      }, { once: true });
    }
  });

  function adjustArticulatedMaxHeights() {
    const wpadminbar = document.getElementById('wpadminbar');
    const wpadminbarHeight = wpadminbar ? wpadminbar.clientHeight : 0;
    const articulated = document.getElementById('articulated');
    const navbarCollapse = document.getElementById('navbar-collapse');
    const navbarCollapseHeight = navbarCollapse ? navbarCollapse.clientHeight : 0;
    const heightOffset = 50 + wpadminbarHeight + navbarCollapseHeight;
    articulated.style.maxHeight = `calc(100vh - ${heightOffset}px)`;
  }

  function restoreArticulatedMaxHeights() {
    const articulated = document.getElementById('articulated');
    articulated.style.maxHeight = '';
  }

  // Prevents website layout from breaking if the wordpress admin bar is displayed.
  document.addEventListener('DOMContentLoaded', function() {
    const wpadminbar = document.getElementById('wpadminbar');
    const navigation = document.getElementById('navigation');
    if (wpadminbar) { // if admin bar visible
      // Trigger your JavaScript functions here
      wpadminbarHeight = wpadminbar.clientHeight;
      if (navigation) {
        navigationHeight = navigation ? navigation.clientHeight : 0;
      } else {
        console.error('ERROR: Element wiht "navigation" as ID is missing!');
      }
      document.getElementById('articulated').classList.add('overlay-active');
      document.getElementById('mvic-map-canvas').classList.add('overlay-active');
      // document.getElementsByTagName('body')[0].classList.add('overlay-active');
      // document.getElementsByTagName('html')[0].classList.add('overlay-active');
    } else {
      console.log('Element with "wpadminbar" as ID is missing.');
      wpadminbarHeight = 0;
      document.getElementById('articulated').classList.remove('overlay-active');
      document.getElementById('mvic-map-canvas').classList.remove('overlay-active');
      // document.getElementsByTagName('body')[0].classList.remove('overlay-active');
      // document.getElementsByTagName('html')[0].classList.remove('overlay-active');
    }
  });

  // Displays business hours status on restaurant page
  document.addEventListener('DOMContentLoaded', function() {
    if (typeof businessHours !== 'undefined') {
      const statusElement = document.getElementById('bh-status');
      const statusObj = getRestaurantBusinessHoursStatus(businessHours);
      statusElement.textContent = statusObj.status;
      statusElement.className = statusObj.className;
    } else {
      console.error('businessHours is not defined');
    }
  });

})();
