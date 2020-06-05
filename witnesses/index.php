<?php
$title = 'Witnesses';
$subNavOpen = '#NavbarHearings';
include($_SERVER['DOCUMENT_ROOT'] . '/includes/head.php');
?>
<?php
include($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include($_SERVER['DOCUMENT_ROOT'] . '/includes/navbar.php');
?>
<h1>Witnesses</h1>
<noscript>You need to enable JavaScript to run this app.</noscript>
<p style="font-size: 0.85rem; text-align: center">If you know the name of the witness, please click on the first letter of their surname.<br />
    You will see their name listed. If you click on that name, the date(s) of testimony are listed.</p>
<p style="font-size: 0.85rem; text-align: center">If you would like to see the schedule of witnesses by date please <a href="/schedule/">click here</a>.</p>
<div id="root"></div>
<p id="IEMessage">If you are seeing this message then it means that your browser doesn't work with our site. Please upgrade your <a href="https://www.google.ca/chrome/">browser for free</a>.</p>
<noscript>You need to enable JavaScript to run this app.</noscript>
<div id="root"></div>
<script src="/js/axios.min.js"></script>
<script src="/js/react.production.min.js"></script>
<script src="/js/react-dom.production.min.js"></script>
<script src="/js/babel.js"></script>
<script src="/js/date-format/date.format.js"></script>
<script src="/js/propTypes.js"></script>
<script src="/js/classNames.js"></script>
<script type="text/babel">

class App extends React.Component {

    getUrlParameter(name) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        var results = regex.exec(window.location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    };

    render() {
        if (state.isInit) {
            let alphabetList = new Map();
            for (let i = 'A'.charCodeAt(0); i <= 'Z'.charCodeAt(0); i++) {
                alphabetList.set(String.fromCharCode(i), []);
            }
            for (const witness of state.witnesses) {
                let firstChar = witness[1].lastName.charAt(0);
                let uppercase = firstChar.toUpperCase();
                alphabetList.get(uppercase).push(witness);
            }
            let witnessList = [];
            if (state.noWitnesses) {
                witnessList.push(<p>Exhibits will be posted here once they are uploaded.</p>);
            } else {
                for (const alpha of alphabetList) {
                    witnessList.push(<WitnessList key={alpha[0]} witnessList={alpha}></WitnessList>);
                }
            }
            return (
                <div id="App">
                    {witnessList}
                </div>
            );
        } else {
            let isDev = this.getUrlParameter('dev');
            let url = '/data/hearings.json';
            if (isDev === 't') {
                url = '/dataDev/hearings.json';
            }
            axios.get(url)
            .then((res) => {
                if (res.data.hearings === undefined) {
                    cl('NO HEARINGS SCHEDULED', WARNING);
                } else {
                    state.witnesses = [];
                    state.hearings = [];
                    for (const hearing of res.data.hearings) {
                        state.hearings.push(hearing[1]);
                    }
                    if (res.data.witnesses.length > 0) {
                        state.witnesses = res.data.witnesses;
                    } else {
                        state.noWitnesses = true;
                    }
                }
                state.isInit = true;
                state.isDev = isDev;
                cl('WITNESSES INITIALIZED', SUCCESS);
                this.forceUpdate();
            });
            return (
                <div id="App">
                </div>
            );
        }
    }
}

class WitnessList extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            openList: false
        };
    }

    handleOpenListClick() {
        if (this.props.witnessList[1].length > 0) {
            this.setState({
                openList: !this.state.openList
            });
        }
    }

    render() {
        let displayList = 0;
        if (this.state.openList) {
            displayList = 'auto';
        }
        let cssClass = '';
        let chevron = null;
        if (this.props.witnessList[1].length === 0) {
            cssClass = 'NoWitnesses';
            if (this.state.openList) {
                this.setState({
                    openList: false
                });
            }
        } else {
            if (this.state.openList) {
                chevron = <i key={this.props.witnessList[0]} className="fas fa-chevron-up WitnessOpenButton"></i>;
            } else {
                chevron = <i key={this.props.witnessList[0]} className="fas fa-chevron-down WitnessOpenButton"></i>;
            }
            cssClass = 'WitnessListActive';
        }
        let witnesses = [];
        for (const witness of this.props.witnessList[1]) {
            witnesses.push(<Witness key={witness[0]} witnessId={witness[0]} witness={witness[1]}></Witness>);
        }
        return (
            <div className="WitnessListContainer">
                <div className={cssClass} onClick={this.handleOpenListClick.bind(this)}>
                    {chevron}
                    <h2 className="WitnessAlphabetTitle">{this.props.witnessList[0]}</h2>
                </div>
                <AnimateHeight duration={500} height={displayList}>
                    <div className="WitnessList">
                        {witnesses}
                    </div>
                </AnimateHeight>
            </div>
        );
    }
}

class Witness extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            display: false
        }
    }

    displayHearingList() {
        this.setState({
            display: !this.state.display
        });
    }

    render() {
        let displayList = 0;
        if (this.state.display) {
            displayList = 'auto';
        }
        let prefix = this.props.witness.prefix;
        let firstName = this.props.witness.firstName;
        let lastName = this.props.witness.lastName;
        let title = this.props.witness.title;
        let fullName = '';
        if (prefix !== '') {
            fullName = prefix + ' ';
        }
        fullName += firstName + ' ' + lastName;
        let fullTitle = '';
        if (title !== '') {
            fullTitle = ', (' + title + ')';
        }
        let chevron = <i key={fullName + fullTitle} className="fas fa-chevron-down HearingsListOpenButton"></i>;
        if (this.state.display) {
            chevron = <i key={fullName + fullTitle} className="fas fa-chevron-up HearingsListOpenButton"></i>;
        }
        let hearingList = [];
        let hearingsListCss = 'NamesOfWitnesses';
        if (state.hearings.length > 0) {
            for (const hearing of state.hearings) {
                let found = false;
                if (hearing.themes.length > 0) {
                    for (const theme of hearing.themes) {
                        if (theme[1].length > 0) {
                            for (const witness of theme[1]) {
                                if (witness === this.props.witnessId) {
                                    let hearingDate = new Date(hearing.timeStamp);
                                    hearingList.push(<p className="HearingDateLink"><a href={"/schedule/?h=" + hearing.timeStamp}>{hearingDate.format('j F, Y')}</a></p>);
                                    found = true;
                                    break;
                                }
                            }
                            if (found) {
                                break;
                            }
                        }
                    }
                }
            }
        } else {
            hearingsListCss += ' WitnessNotScheduled';
        }
        return (
            <div className="UpdateWitnessTitlebar">
                {chevron}
                <p className={hearingsListCss} onClick={this.displayHearingList.bind(this)}><strong>{fullName}</strong>{fullTitle}</p>
                <div className="WitnessHearingsList">
                    <AnimateHeight duration={500} height={displayList}>
                        {hearingList}
                    </AnimateHeight>
                </div>
            </div>
        );
    }
}

const ERROR = 'font-weight: bold; color: red';
const WARNING = 'font-weight: bold; color: orange';
const INFO = 'font-weight: bold; color: blue';
const SUCCESS = 'font-weight: bold; color: green';
const GENERAL = 'font-weight: bold; color: grey';

function cl(msg, css) {
    console.log('%c' + msg, css);
}

const state = {
    isInit: false,
    isDev: false,
    noWitnesses: false,
    witnesses: null,
    hearings: null
};

function sortWitnessArray(a, b) {
    return b[0].localeCompare(a[0], 'en', {numeric: true, sensitivity: 'base'});
}


/* ANIMATE HEIGHT */

const ANIMATION_STATE_CLASSES = {
  animating: 'rah-animating',
  animatingUp: 'rah-animating--up',
  animatingDown: 'rah-animating--down',
  animatingToHeightZero: 'rah-animating--to-height-zero',
  animatingToHeightAuto: 'rah-animating--to-height-auto',
  animatingToHeightSpecific: 'rah-animating--to-height-specific',
  static: 'rah-static',
  staticHeightZero: 'rah-static--height-zero',
  staticHeightAuto: 'rah-static--height-auto',
  staticHeightSpecific: 'rah-static--height-specific',
};

const PROPS_TO_OMIT = [
  'animateOpacity',
  'animationStateClasses',
  'applyInlineTransitions',
  'children',
  'contentClassName',
  'delay',
  'duration',
  'easing',
  'height',
  'onAnimationEnd',
  'onAnimationStart',
];

function omit(obj, ...keys) {
  if (!keys.length) {
    return obj;
  }

  const res = {};
  const objectKeys = Object.keys(obj);

  for (let i = 0; i < objectKeys.length; i++) {
    const key = objectKeys[i];

    if (keys.indexOf(key) === -1) {
      res[key] = obj[key];
    }
  }

  return res;
}

// Start animation helper using nested requestAnimationFrames
function startAnimationHelper(callback) {
  const requestAnimationFrameIDs = [];

  requestAnimationFrameIDs[0] = requestAnimationFrame(() => {
    requestAnimationFrameIDs[1] = requestAnimationFrame(() => {
      callback();
    });
  });

  return requestAnimationFrameIDs;
}

function cancelAnimationFrames(requestAnimationFrameIDs) {
  requestAnimationFrameIDs.forEach(id => cancelAnimationFrame(id));
}

function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

function isPercentage(height) {
  // Percentage height
  return typeof height === 'string' &&
    height.search('%') === height.length - 1 &&
    isNumber(height.substr(0, height.length - 1));
}

function runCallback(callback, params) {
  if (callback && typeof callback === 'function') {
    callback(params);
  }
}

const AnimateHeight = class extends React.Component {
  constructor(props) {
    super(props);

    this.animationFrameIDs = [];

    let height = 'auto';
    let overflow = 'visible';

    if (isNumber(props.height)) {
      // If value is string "0" make sure we convert it to number 0
      height = props.height < 0 || props.height === '0' ? 0 : props.height;
      overflow = 'hidden';
    } else if (isPercentage(props.height)) {
      // If value is string "0%" make sure we convert it to number 0
      height = props.height === '0%' ? 0 : props.height;
      overflow = 'hidden';
    }

    this.animationStateClasses = { ...ANIMATION_STATE_CLASSES, ...props.animationStateClasses };

    const animationStateClasses = this.getStaticStateClasses(height);

    this.state = {
      animationStateClasses,
      height,
      overflow,
      shouldUseTransitions: false,
    };
  }

  componentDidMount() {
    const { height } = this.state;

    // Hide content if height is 0 (to prevent tabbing into it)
    // Check for contentElement is added cause this would fail in tests (react-test-renderer)
    // Read more here: https://github.com/Stanko/react-animate-height/issues/17
    if (this.contentElement && this.contentElement.style) {
      this.hideContent(height);
    }
  }

  componentDidUpdate(prevProps, prevState) {
    const {
      delay,
      duration,
      height,
      onAnimationEnd,
      onAnimationStart,
    } = this.props;

    // Check if 'height' prop has changed
    if (this.contentElement && height !== prevProps.height) {
      // Remove display: none from the content div
      // if it was hidden to prevent tabbing into it
      this.showContent(prevState.height);

      // Cache content height
      this.contentElement.style.overflow = 'hidden';
      const contentHeight = this.contentElement.offsetHeight;
      this.contentElement.style.overflow = '';

      // set total animation time
      const totalDuration = duration + delay;

      let newHeight = null;
      const timeoutState = {
        height: null, // it will be always set to either 'auto' or specific number
        overflow: 'hidden',
      };
      const isCurrentHeightAuto = prevState.height === 'auto';


      if (isNumber(height)) {
        // If value is string "0" make sure we convert it to number 0
        newHeight = height < 0 || height === '0' ? 0 : height;
        timeoutState.height = newHeight;
      } else if (isPercentage(height)) {
        // If value is string "0%" make sure we convert it to number 0
        newHeight = height === '0%' ? 0 : height;
        timeoutState.height = newHeight;
      } else {
        // If not, animate to content height
        // and then reset to auto
        newHeight = contentHeight; // TODO solve contentHeight = 0
        timeoutState.height = 'auto';
        timeoutState.overflow = null;
      }

      if (isCurrentHeightAuto) {
        // This is the height to be animated to
        timeoutState.height = newHeight;

        // If previous height was 'auto'
        // set starting height explicitly to be able to use transition
        newHeight = contentHeight;
      }

      // Animation classes
      const animationStateClasses = classNames({
        [this.animationStateClasses.animating]: true,
        [this.animationStateClasses.animatingUp]: prevProps.height === 'auto' || height < prevProps.height,
        [this.animationStateClasses.animatingDown]: height === 'auto' || height > prevProps.height,
        [this.animationStateClasses.animatingToHeightZero]: timeoutState.height === 0,
        [this.animationStateClasses.animatingToHeightAuto]: timeoutState.height === 'auto',
        [this.animationStateClasses.animatingToHeightSpecific]: timeoutState.height > 0,
      });

      // Animation classes to be put after animation is complete
      const timeoutAnimationStateClasses = this.getStaticStateClasses(timeoutState.height);

      // Set starting height and animating classes
      // We are safe to call set state as it will not trigger infinite loop
      // because of the "height !== prevProps.height" check
      this.setState({ // eslint-disable-line react/no-did-update-set-state
        animationStateClasses,
        height: newHeight,
        overflow: 'hidden',
        // When animating from 'auto' we first need to set fixed height
        // that change should be animated
        shouldUseTransitions: !isCurrentHeightAuto,
      });

      // Clear timeouts
      clearTimeout(this.timeoutID);
      clearTimeout(this.animationClassesTimeoutID);

      if (isCurrentHeightAuto) {
        // When animating from 'auto' we use a short timeout to start animation
        // after setting fixed height above
        timeoutState.shouldUseTransitions = true;

        cancelAnimationFrames(this.animationFrameIDs);
        this.animationFrameIDs = startAnimationHelper(() => {
          this.setState(timeoutState);

          // ANIMATION STARTS, run a callback if it exists
          runCallback(onAnimationStart, { newHeight: timeoutState.height });
        });

        // Set static classes and remove transitions when animation ends
        this.animationClassesTimeoutID = setTimeout(() => {
          this.setState({
            animationStateClasses: timeoutAnimationStateClasses,
            shouldUseTransitions: false,
          });

          // ANIMATION ENDS
          // Hide content if height is 0 (to prevent tabbing into it)
          this.hideContent(timeoutState.height);
          // Run a callback if it exists
          runCallback(onAnimationEnd, { newHeight: timeoutState.height });
        }, totalDuration);
      } else {
        // ANIMATION STARTS, run a callback if it exists
        runCallback(onAnimationStart, { newHeight });

        // Set end height, classes and remove transitions when animation is complete
        this.timeoutID = setTimeout(() => {
          timeoutState.animationStateClasses = timeoutAnimationStateClasses;
          timeoutState.shouldUseTransitions = false;

          this.setState(timeoutState);

          // ANIMATION ENDS
          // If height is auto, don't hide the content
          // (case when element is empty, therefore height is 0)
          if (height !== 'auto') {
            // Hide content if height is 0 (to prevent tabbing into it)
            this.hideContent(newHeight); // TODO solve newHeight = 0
          }
          // Run a callback if it exists
          runCallback(onAnimationEnd, { newHeight });
        }, totalDuration);
      }
    }
  }

  componentWillUnmount() {
    cancelAnimationFrames(this.animationFrameIDs);

    clearTimeout(this.timeoutID);
    clearTimeout(this.animationClassesTimeoutID);

    this.timeoutID = null;
    this.animationClassesTimeoutID = null;
    this.animationStateClasses = null;
  }

  showContent(height) {
    if (height === 0) {
      this.contentElement.style.display = '';
    }
  }

  hideContent(newHeight) {
    if (newHeight === 0) {
      this.contentElement.style.display = 'none';
    }
  }

  getStaticStateClasses(height) {
    return classNames({
      [this.animationStateClasses.static]: true,
      [this.animationStateClasses.staticHeightZero]: height === 0,
      [this.animationStateClasses.staticHeightSpecific]: height > 0,
      [this.animationStateClasses.staticHeightAuto]: height === 'auto',
    });
  }

  render() {
    const {
      animateOpacity,
      applyInlineTransitions,
      children,
      className,
      contentClassName,
      duration,
      easing,
      delay,
      style,
    } = this.props;
    const {
      height,
      overflow,
      animationStateClasses,
      shouldUseTransitions,
    } = this.state;


    const componentStyle = {
      ...style,
      height,
      overflow: overflow || style.overflow,
    };

    if (shouldUseTransitions && applyInlineTransitions) {
      componentStyle.transition = `height ${ duration }ms ${ easing } ${ delay }ms`;

      // Include transition passed through styles
      if (style.transition) {
        componentStyle.transition = `${ style.transition }, ${ componentStyle.transition }`;
      }

      // Add webkit vendor prefix still used by opera, blackberry...
      componentStyle.WebkitTransition = componentStyle.transition;
    }

    const contentStyle = {};

    if (animateOpacity) {
      contentStyle.transition = `opacity ${ duration }ms ${ easing } ${ delay }ms`;
      // Add webkit vendor prefix still used by opera, blackberry...
      contentStyle.WebkitTransition = contentStyle.transition;

      if (height === 0) {
        contentStyle.opacity = 0;
      }
    }

    const componentClasses = classNames({
      [animationStateClasses]: true,
      [className]: className,
    });

    return (
      <div
        { ...omit(this.props, ...PROPS_TO_OMIT) }
        aria-hidden={ height === 0 }
        className={ componentClasses }
        style={ componentStyle }
      >
        <div
          className={ contentClassName }
          style={ contentStyle }
          ref={ el => this.contentElement = el }
        >
          { children }
        </div>
      </div>
    );
  }
};

const heightPropType = (props, propName, componentName) => {
  const value = props[propName];

  if ((typeof value === 'number' && value >= 0) || isPercentage(value) || value === 'auto') {
    return null;
  }

  return new TypeError(
    `value "${ value }" of type "${ typeof value }" is invalid type for ${ propName } in ${ componentName }. ` +
    'It needs to be a positive number, string "auto" or percentage string (e.g. "15%").'
  );
};

AnimateHeight.propTypes = {
  animateOpacity: PropTypes.bool,
  animationStateClasses: PropTypes.object,
  applyInlineTransitions: PropTypes.bool,
  children: PropTypes.any.isRequired,
  className: PropTypes.string,
  contentClassName: PropTypes.string,
  duration: PropTypes.number,
  delay: PropTypes.number,
  easing: PropTypes.string,
  height: heightPropType,
  onAnimationEnd: PropTypes.func,
  onAnimationStart: PropTypes.func,
  style: PropTypes.object,
};

AnimateHeight.defaultProps = {
  animateOpacity: false,
  animationStateClasses: ANIMATION_STATE_CLASSES,
  applyInlineTransitions: true,
  duration: 250,
  delay: 0,
  easing: 'ease',
  style: {},
};

ReactDOM.render(<App />, document.getElementById('root'));

</script>
<p>The Commission plans to post its witness lists on its website in advance of the witnesses testifying. These lists will be subject to modification if Commission Counsel determines that a witness is unnecessary or that an additional witness is required.</p>
<p>Additional information about the witness lists will be provided in due course.</p>
<?php
include($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php');
?>