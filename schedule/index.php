<?php
$title = 'Hearings Calendar';
$subNavOpen = '#NavbarHearings';
$navSchedule = true;
include($_SERVER['DOCUMENT_ROOT'] . '/includes/head.php');
?>
<?php
include($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include($_SERVER['DOCUMENT_ROOT'] . '/includes/navbar.php');
?>
<h1>Hearings Schedule</h1>
<p>While the Commission has made efforts to organize the hearings thematically, the topic of money laundering does not lend itself to silos and witnesses may address a variety of different topics in their testimony, not limited to the sector in question. As well, witnesses called during later portions of the hearings, may have additional evidence to present on the topic of gaming, casinos, and horse racing.</p>
<p>To view the livestream video archives of past hearings, please see our <a href="/webcast-archive/">webcast archive section</a>.</p>
<div id="root"></div>
<p id="IEMessage">If you are seeing this message then it means that your browser doesn't work with our site. Please upgrade your <a href="https://www.google.ca/chrome/">browser for free</a>.</p>
<noscript>You need to enable JavaScript to run this app.</noscript>
<script src="/js/axios.min.js"></script>
<script src="/js/react.production.min.js"></script>
<script src="/js/react-dom.production.min.js"></script>
<script src="/js/babel.js"></script>
<script src="/js/date-format/date.format.js"></script>
<script src="/js/propTypes.js"></script>
<script src="/js/classNames.js"></script>
<script src="/js/marked.js"></script>
<script src="./js/glide.min.js"></script>
<link rel="stylesheet" href="./css/glide.core.min.css" />
<link rel="stylesheet" href="./css/glide.theme.css" />
<script type="text/babel">

  class App extends React.Component {
    constructor (props) {
      super(props);
      this.state = {};
    }

  getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(window.location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
  };

  forceAppUpdate() {
    this.setState({});
  }

  handleWeekDayClick(e) {
    let hearingID = parseInt(e.currentTarget.dataset.hearingdate);
    if (state.selectedHearing === null) {
      selectHearing(hearingID);
      showHearing();
      scrollToVideo();
    } else {
      if (state.selectedHearing.timeStamp === hearingID) {
        hideHearing();
        setTimeout(() => { deSelectHearing(); }, 600);
      } else {
        hideHearing();
        setTimeout(
          () => {
            selectHearing(hearingID);
            showHearing();
            scrollToVideo();
            this.forceAppUpdate();
          }, 750);
      }
    }
    this.forceAppUpdate();
  }

  render() {
    if (state.isInit) {
      let mainHeight = 0;
      if (state.displayHearing) {
        mainHeight = 'auto';
      }
      let calendarGlide = [];
      let glideBullets = [];
      let endTS = 0;
      for (const hearingTS of state.hearings.keys()) {
        endTS = (hearingTS > endTS) ? hearingTS : endTS;
      }
      let startDate = new Date(2020, 0, 1, 0, 0, 0, 0);
      startDate.setDate(1);
      let endDate = new Date(endTS);
      let numMonths = (endDate.getFullYear() - startDate.getFullYear()) * 12;
      numMonths -= startDate.getMonth() + 1;
      numMonths += endDate.getMonth() + 2;  // Adds an extra month to allow for adding new dates beyond the last month.
      numMonths = ((numMonths <= 3) ? 3 : numMonths) + 1;  // Make sure it always has three months.
      visibleSlides = (isMobile) ? 1 : 3;
      endOfCarousel = (isMobile) ? numMonths - visibleSlides - 2 : numMonths - visibleSlides;
      for (let i = 0; i < numMonths; i++) {
        let newDate = new Date(startDate)
        newDate.setMonth(startDate.getMonth() + i);
        calendarGlide.push(<Month key={newDate.getTime()} date={newDate} calendarType={CALENDAR} forceApp={this.forceAppUpdate.bind(this)}></Month>);
        glideBullets.push(<button class="glide__bullet" data-glide-dir={ '=' + i}>{newDate.format('M')}</button>);
      }
      let selectedHearingKey = "NoHearing";
      if (state.selectedHearing !== null) {
        selectedHearingKey = state.selectedHearing.timeStamp;
      }
      let isDevHeader = '';
      if (state.isDev) {
        isDevHeader = <h2 style={{ borderRadius: '5px', fontWeight: '800', fontSize: '4.7rem', textAlign: 'center', textTransform: 'uppercase', color: 'white', backgroundColor: '#6200ffc4', padding: '10px', position: 'absolute', top: '150px', left: '50%', textShadow: '0px 0px 20px black', transform: 'rotate(10deg) translate(-35%, 0%)', width: '850px' }}>TEST VERSION</h2>
      }
      let reverseOrder = [];
      for (const reverseHearings of state.hearings.values()) {
        reverseOrder.push(reverseHearings);
      }
      reverseOrder.reverse();
      let scheduleList = [];
      let pastDates = false;
      let currentDay = new Date(new Date().format('M j, Y')).getTime();
      scheduleList.push(<p style={{backgroundColor: '#ccc', textAlign: 'center', padding: '5px', gridColumn: '1 / span 3'}}><strong>UPCOMING HEARINGS: GAMING, CASINOS AND HORSE RACING</strong></p>);
      scheduleList.push(<p><strong><u>Date</u></strong></p>)
      scheduleList.push(<p><strong><u>Witness Name</u></strong></p>)
      scheduleList.push(<p></p>)
      for (const listHearing of reverseOrder) {
        if (listHearing.isCancelled === false) {
          let listDate = new Date(listHearing.timeStamp);
          if (listDate.getTime() < currentDay && pastDates === false) {
            pastDates = true;
            if (scheduleList.length >= 0) {
              //  Some hearings are scheduled in the future.
              scheduleList.push(<p style={{backgroundColor: '#ccc', textAlign: 'center', padding: '5px', gridColumn: '1 / span 3'}}><strong>PAST HEARINGS</strong></p>);
              scheduleList.push(<p><strong><u>Date</u></strong></p>)
              scheduleList.push(<p><strong><u>Witness Name</u></strong></p>)
              scheduleList.push(<p><strong><u>Transcript</u></strong></p>)
            }
          }
          if (listHearing.themes.size > 0) {
            scheduleList.push(<p>{listDate.format('F j, Y')}</p>);
            for (const hearingWitnessList of listHearing.themes.values()) {
              let witnessList = [];
              for (const witnessID of hearingWitnessList) {
                let nameObj = state.witnesses.get(witnessID);
                let fullName = '';
                if (nameObj.prefix !== '') {
                  fullName = nameObj.prefix + ' ';
                }
                if (nameObj.firstName !== '' && nameObj.lastName !== '') {
                  fullName += nameObj.firstName + ' ' + nameObj.lastName;
                } else if (nameObj.firstName !== '') {
                  fullName += nameObj.firstName;
                } else if (nameObj.lastName !== '') {
                  fullName += nameObj.lastName;
                }
                let titleName = '';
                if (nameObj.title !== '') {
                  titleName += ', ' + nameObj.title;
                }
                witnessList.push(<li><strong>{fullName}</strong>{titleName}</li>);
              }
              scheduleList.push(<ul className='ScheduleListWitnesses'>{witnessList}</ul>);
            }
            let transcriptLink = (pastDates) ? <p>Transcripts to be uploaded.</p> : <p></p>;
            if (listHearing.transcriptLink !== '') {
                if (state.isDev) {
                    transcriptLink = <p key='TranscriptLink'><a href={"/dataDev/transcripts/" + listHearing.transcriptLink} target="_blank">{listHearing.transcriptLink}</a></p>;
                } else {
                    transcriptLink = <p key='TranscriptLink'><a href={"/data/transcripts/" + listHearing.transcriptLink} target="_blank">{listHearing.transcriptLink}</a></p>;
                }
            }
            scheduleList.push(transcriptLink);
          }
        }
      }
      return (
        <div id="App">
          {isDevHeader}
          <div className="ScheduleList">
            {scheduleList}
          </div>
          <p style={{fontSize: '0.85rem', textAlign: 'center'}}>Please click on the date to display that hearing information.</p>
          <div className="HearingsCalendarApp">
            <div className="glide">
              <div className="glide__track" data-glide-el="track">
                <ul className="glide__slides">
                  {calendarGlide}
                </ul>
              </div>
              <div className="glide">
                <div className="glide__bullets" data-glide-el="controls[nav]">
                  {glideBullets}
                </div>
              </div>
              <div className="glide__arrows" data-glide-el="controls">
                <button className="glide__arrow" data-glide-dir="<<"><i className="fas fa-chevron-left"></i><i className="fas fa-chevron-left"></i></button>
                <button className="glide__arrow glide__arrow--left" data-glide-dir="<"><i className="fas fa-chevron-left"></i></button>
                <button className="glide__arrow glide__arrow--right" data-glide-dir=">"><i className="fas fa-chevron-right"></i></button>
                <button className="glide__arrow" data-glide-dir=">>"><i className="fas fa-chevron-right"></i><i className="fas fa-chevron-right"></i></button>
              </div>
            </div>
          </div>
          <AnimateHeight duration={500} height={mainHeight}>
            <SelectedHearing key={selectedHearingKey} forceApp={this.forceAppUpdate.bind(this)}></SelectedHearing>
          </AnimateHeight>
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
            state.themes = loadThemes(res.data);
            state.witnesses = loadWitnesses(res.data);
            state.hearings = new Map();
            if (res.data.hearings === undefined) {
                cl('NO HEARINGS SCHEDULED', WARNING_CSS);
            } else {
                let tmpHearings = new Map(res.data.hearings);
                for (const hearing of tmpHearings.entries()) {
                    let preppedHearing = hearing[1];
                    preppedHearing.themes = new Map(preppedHearing.themes);
                    state.hearings.set(hearing[0], preppedHearing);
                }
            }
            state.isInit = true;
            state.isDev = isDev;
            let preSelect = this.getUrlParameter('h');
            if (preSelect !== '') {
                let id = parseInt(preSelect);
                if (isNaN(id) === false) {
                    selectHearing(id);
                    showHearing();
                }
            }
            let videoIdQuery = this.getUrlParameter('v');
            if (videoIdQuery !== '') {
                let videoSession = '';
                if (videoIdQuery === 'm') {
                    videoSession = state.selectedHearing.morningVideo;
                } else if (videoIdQuery === 'a') {
                    videoSession = state.selectedHearing.afternoonVideo;
                }
                if (videoSession !== '') {
                    setTimeout(() => {
                            playVideo(videoSession);
                            showHideVideo(true);
                            scrollToVideo();
                        }, 500);
                }
            }
            cl('EDITOR INITIALIZED', SUCCESS_CSS);
            this.forceUpdate();
            new Glide('.glide',
              {
                type: 'slider',
                startAt: endOfCarousel,
                perView: visibleSlides,
                rewind: false,
                throttle: 0
              }
            ).mount()
        });
      return (
        <div id="App">
        </div>
      );
    }
  }

}

class Month extends React.Component {
  render() {
    let daysOfMonth = [];
    let startWeekDay = this.props.date.getDay();
    if (startWeekDay !== 0) {
      for (let clear = 0; clear < startWeekDay; clear++) {
        daysOfMonth.push(<Day key={ clear } clearDay={ true }></Day>)
      }
    }
    let maxDaysInMonth = this.props.date.format('t');
    for (let i = 1; i <= maxDaysInMonth; i++) {
      let currentDate = new Date(this.props.date.getFullYear(), this.props.date.getMonth(), i);
      daysOfMonth.push(<Day key={ currentDate.getTime() } date={ currentDate } calendarType={this.props.calendarType} forceApp={this.props.forceApp}></Day>);
    }
    let monthClasses = 'Month';
    let today = new Date();
    if (this.props.date.getFullYear() === today.getFullYear() && this.props.date.getMonth() === today.getMonth()) {
      monthClasses += ' CurrentMonth';
    }
    return (
      <div className={ monthClasses }>
        <div>
          <h2 className="MonthName">{ this.props.date.format('F') } <span className="YearTitle">{ this.props.date.getFullYear() }</span></h2>
        </div>
        <div className="DaysOfMonth">
          <p className="WeekNames">Sun</p>
          <p className="WeekNames">Mon</p>
          <p className="WeekNames">Tue</p>
          <p className="WeekNames">Wed</p>
          <p className="WeekNames">Thu</p>
          <p className="WeekNames">Fri</p>
          <p className="WeekNames">Sat</p>
          { daysOfMonth }
        </div>
      </div>
    );
  }
}

class Day extends React.Component {
    constructor(props) {
      super(props);
      if (props.date !== undefined) {
        this.state = {
          hearing: state.hearings.get(props.date.getTime())
        };
      } else {
        this.state = {
          hearing: null
        };
      }
    }

    handleDayClick() {
        if (state.selectedHearing === null) {
            selectHearing(this.props.date.getTime());
            showHearing();
            scrollToVideo();
        } else if (this.state.hearing !== null) {
            if (state.selectedHearing.timeStamp === this.state.hearing.timeStamp) {
                hideHearing();
                setTimeout(() => { deSelectHearing(); }, 600);
            } else {
                hideHearing();
                setTimeout(
                    () => {
                        selectHearing(this.state.hearing.timeStamp);
                        showHearing();
                        scrollToVideo();
                        this.props.forceApp();
                    }, 750);
            }
        }
        this.props.forceApp();
    }

    render() {
        if (this.props.clearDay) {
            return (
                <div className="ClearDay"></div>
            );
        } else {
            let cssClasses = 'DayNoSelection';
            let today = new Date();
            let hasHearing = state.hearings.has(this.props.date.getTime());
            if (hasHearing) {
              let hearing = state.hearings.get(this.props.date.getTime());
              if (hearing.isCancelled) {
                  cssClasses += ' CancelledHearing';
              } else {
                  cssClasses += ' EvidentiaryHearing';
              }
            }
            return (
                <div className={ cssClasses } onClick={ this.handleDayClick.bind(this) }>{ this.props.date.getDate() }</div>
            );
        }
    }
}

class SelectedHearing extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      playingMorningVideo: false,
      playingAfternoonVideo: false,
    };
    this.scrollToHearing = React.createRef();
  }

  componentDidMount(prevProps) {
    if (state.selectedHearing !== null && state.selectedHearing.notifications !== '') {
      document.getElementById('MarkDownArea').innerHTML = marked(state.selectedHearing.notifications);
    }
  }

  handleWatchMorningVideoClick() {
      if (state.videoToWatch === state.selectedHearing.morningVideo) {
          showHideVideo(false);
          setTimeout(() => {
              playVideo('');
              this.props.forceApp();
          }, 500);
      } else {
          playVideo(state.selectedHearing.morningVideo);
          showHideVideo(true);
          scrollToVideo();
      }
      this.props.forceApp();
  }

  handleWatchAfternoonVideoClick() {
      if (state.videoToWatch === state.selectedHearing.afternoonVideo) {
          showHideVideo(false);
          setTimeout(() => {
              playVideo('');
              this.props.forceApp();
          }, 500);
      } else {
          playVideo(state.selectedHearing.afternoonVideo);
          showHideVideo(true);
          scrollToVideo();
      }
      this.props.forceApp();
  }

  render() {
      let hearingTitleDate = '';
      let notifications = [];
      if (state.selectedHearing !== null) {
          if (state.selectedHearing.notifications !== '') {
              notifications.push(
                  (
                      <div key="Notifications">
                          <h2 className="HearingFormSectionTitle">Notifications</h2>
                          <div id="MarkDownArea" className="MarkdownPreview">
                          </div>
                      </div>
                  )
              );
          }
          if (state.selectedHearing.isCancelled) {
              hearingTitleDate = new Date(state.selectedHearing.timeStamp).format('F j, Y');
              return (
                  <div className="SelectedHearing">
                      <h2 className="HearingSectionMainTitle">{hearingTitleDate} <span style={{ color: 'red', fontWeight: '400' }}>Hearing Cancelled</span></h2>
                      {notifications}
                  </div>
              );
          } else {
              let topNotification = [];  // Any tags you place in here will appear at the top of the selected hearing area as a notification.
              let themesList = [];
              let exhibitsList = [];
              let buildingRoom = '';
              let street = '';
              let city = '';
              let morningSession = '';
              let afternoonSession = '';
              hearingTitleDate = new Date(state.selectedHearing.timeStamp).format('F j, Y');
              buildingRoom = state.selectedHearing.buildingRoom;
              street = state.selectedHearing.street;
              city = state.selectedHearing.city;
              morningSession = state.selectedHearing.morningSession;
              if (state.selectedHearing.afternoonSession !== '') {
                afternoonSession = 'Hearing Session 2: ' + state.selectedHearing.afternoonSession;
              }
              if (state.selectedHearing.themes.size === 0) {
                  themesList.push(<p key="NoThemesScheduled">There are no topics scheduled for this hearing.</p>);
              } else {
                  for (const theme of state.selectedHearing.themes.keys()) {
                      themesList.push(<ThemesWitnesses key={theme} themeId={theme}></ThemesWitnesses>);
                  }
              }
              if (state.selectedHearing.exhibits.length === 0) {
                  exhibitsList.push(<p key="NoExhibitsEntered" style={{ gridColumn: '1 / span 2' }} className="HearingInfo">Exhibits for this hearing will be uploaded here</p>);
              } else {
                  for (const exhibit of state.selectedHearing.exhibits) {
                      let url = '/data/exhibits/';
                      if (this.props.isDev) {
                          url = '/dataDev/exhibits/';
                      }
                      exhibitsList.push(<p key={exhibit[0] + 'NUM'}>#{exhibit[0]}</p>);
                      exhibitsList.push(<p key={exhibit[0] + 'LINK'}><a href={url + exhibit[2]}>{exhibit[1]}</a></p>);
                  }
              }
              let transcriptLink = <p key="NoTranscripts" className="HearingInfo"><strong>Transcripts for this session will be uploaded here.</strong></p>;
              if (state.selectedHearing.transcriptLink !== '') {
                  if (this.props.isDev) {
                      transcriptLink = <p key={state.selectedHearing.transcriptLink} style={{marginTop: '0px'}}><a href={"/dataDev/transcripts/" + state.selectedHearing.transcriptLink} target="_blank">{state.selectedHearing.transcriptLink}</a></p>;
                  } else {
                      transcriptLink = <p key={state.selectedHearing.transcriptLink} style={{marginTop: '0px'}}><a href={"/data/transcripts/" + state.selectedHearing.transcriptLink} target="_blank">{state.selectedHearing.transcriptLink}</a></p>;
                  }
              }
              let webcastLink = [];
              if (state.selectedHearing.timeStamp === new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate()).getTime()) {
                  webcastLink = <h3 key="WebcastLink" className="HearingFormSectionTitle" style={{ textAlign: 'center' }}><a href="/webcast-live/" target="_blank">View Live Webcast of this Hearing</a></h3>;
              }
              let timeCss = "HearingInfo";
              let timeNoneDefaultMsg = '';
              if (state.selectedHearing.defaultTime === false) {
                  timeCss += ' NoneDefault';
                  timeNoneDefaultMsg = <span key="NoneDefaultTimeMsg"><br /><br />Notice change in time.</span>
              }
              let locationCss = "HearingInfo";
              let locationNoneDefaultMsg = '';
              if (state.selectedHearing.defaultAddress === false) {
                  locationCss += ' NoneDefault';
                  locationNoneDefaultMsg = <span key="NoneDefaultLocationMsg"><br /><br />Notice change in location.</span>
              }
              let videos = [];
              let morningUploaded = false;
              let afternoonUploaded = false;
              if (state.selectedHearing.morningVideo !== undefined && state.selectedHearing.morningVideo !== '') {
                  morningUploaded = true;
              }
              if (state.selectedHearing.afternoonVideo !== undefined && state.selectedHearing.afternoonVideo !== '') {
                  afternoonUploaded = true;
              }
              if (morningUploaded === false && afternoonUploaded === false) {
                  videos = <p className="HearingInfo"><strong>No videos uploaded at this point.</strong></p>;
              } else if (morningUploaded && afternoonUploaded) {
                  videos.push(<div key={state.selectedHearing.morningVideo} className="Button RegularButton ButtonMarginLeft ButtonMarginRight" onClick={this.handleWatchMorningVideoClick.bind(this)}>Watch Session 1</div>);
                  videos.push(<div key={state.selectedHearing.afternoonVideo} className="Button RegularButton ButtonMarginLeft ButtonMarginRight" onClick={this.handleWatchAfternoonVideoClick.bind(this)}>Watch Session 2</div>);
              } else {
                  if (morningUploaded) {
                      videos = <div key={state.selectedHearing.morningVideo} className="Button RegularButton ButtonMarginLeft ButtonMarginRight" onClick={this.handleWatchMorningVideoClick.bind(this)}>Watch Session</div>;
                  }
                  if (afternoonUploaded) {
                      videos = <div key={state.selectedHearing.afternoonVideo} className="Button RegularButton ButtonMarginLeft ButtonMarginRight" onClick={this.handleWatchAfternoonVideoClick.bind(this)}>Watch Session</div>;
                  }
              }
              let videoHeight = 0;
              let videoPlayer = <p key="Default"></p>;
              if (state.displayVideo) {
                  videoHeight = 'auto';
              }
              if (state.videoToWatch !== '') {
                  let queryStr = '';
                  if (state.scrollToVideo) {
                      queryStr = '?autoplay=1';
                  }
                  videoPlayer = <div key="vimeoplayer" style={{ padding: '56.25% 0 0 0', position: 'relative' }}><iframe src={'https://player.vimeo.com/video/' + state.videoToWatch + queryStr} frameBorder="0" allow="autoplay; fullscreen" allowFullScreen style={{ position: 'absolute', top: '0', left: '0', width: '100%', height: '100%'}}></iframe></div>
              }
              if (state.scrollToVideo) {
                setTimeout(() => {
                  window.scrollTo(0, this.scrollToHearing.current.offsetTop);
                }, 250);
                
              }
              return (
                  <div ref={this.scrollToHearing} className="SelectedHearing">
                      <div className="HearingSectionTitle">
                          <div>
                              <p style={{float: 'left', color: '#999999'}}>Scroll down&nbsp;&nbsp;<i className="fas fa-chevron-down"></i><i className="fas fa-chevron-down"></i></p>
                          </div>
                          <h2 className="HearingSectionMainTitle">{hearingTitleDate}</h2>
                          <div>
                              <p style={{float: 'right', color: '#999999'}}><i className="fas fa-chevron-down"></i><i className="fas fa-chevron-down"></i>&nbsp;&nbsp;Scroll down</p>
                          </div>
                      </div>
                      {webcastLink}
                      <div className="HearingInfoGrid">
                          {topNotification}
                          <div className="HearingTopSectionLayout">
                              <div>
                                  <h3 className="HearingFormSectionTitle">Location</h3>
                                  <p className={locationCss}>{buildingRoom}<br />{street}<br />{city}{locationNoneDefaultMsg}</p>
                              </div>
                              <div>
                                  <h3 className="HearingFormSectionTitle">Transcript</h3>
                                  {transcriptLink}
                              </div>
                              <div>
                                  <h3 className="HearingFormSectionTitle">Time</h3>
                                  <p className={timeCss}>Hearing Session: {morningSession}<br />{afternoonSession}{timeNoneDefaultMsg}</p>
                              </div>
                              <div>
                                  <h3 className="HearingFormSectionTitle">Video</h3>
                                  <div className="VideoListContainer">
                                      {videos}
                                  </div>
                              </div>
                          </div>
                          <AnimateHeight duration={500} height={videoHeight}>
                              {videoPlayer}
                          </AnimateHeight>
                          {notifications}
                          <h2 className="HearingFormSectionTitle">Topics</h2>
                          {themesList}
                          <p style={{fontSize: '0.85rem', textAlign: 'center', marginBottom: '40px'}}>While the Commission has made efforts to organize the hearings thematically, the topic of money laundering does not lend itself to silos and witnesses may address a variety of different topics in their testimony, not limited to the sector in question. As well, witnesses called during later portions of the hearings, may have additional evidence to present on the topic of gaming, casinos, and horse racing.</p>
                          <h2 className="HearingFormSectionTitle">Exhibits</h2>
                          <div className="ExhibitElement">
                              {exhibitsList}
                          </div>
                      </div>
                  </div>
              );
          }
      } else {
          return (
              <div className="SelectedHearing">
              </div>
          );
      }
  }
}

class ThemesWitnesses extends React.Component {
    render() {
        let witnessList = [];
        for (const witnessId of state.selectedHearing.themes.get(this.props.themeId)) {
            let prefix = state.witnesses.get(witnessId).prefix;
            let firstName = state.witnesses.get(witnessId).firstName;
            let lastName = state.witnesses.get(witnessId).lastName;
            let title = state.witnesses.get(witnessId).title;
            let fullName = '';
            if (prefix !== '') {
                fullName = prefix + ' ';
            }
            fullName += firstName + ' ' + lastName;
            let fullTitle = '';
            if (title !== '') {
                fullTitle = ', ' + title;
            }
            witnessList.push(<p key={fullName + fullTitle} className="WitnessListNames"><strong>{fullName}</strong>{fullTitle}</p>)
        }
        return (
            <div className="HearingTheme">
                <p className="HearingThemeName">{state.themes.get(this.props.themeId)}</p>
                {witnessList}
            </div>
        );
    }
}

const ERROR_CSS = 'font-weight: bold; color: red';
const WARNING_CSS = 'font-weight: bold; color: orange';
const INFO_CSS = 'font-weight: bold; color: blue';
const SUCCESS_CSS = 'font-weight: bold; color: green';
const GENERAL_CSS = 'font-weight: bold; color: grey';

function cl(msg, css) {
    console.log('%c' + msg, css);
}

let endOfCarousel;

const state = {
    isInit: false,
    isDev: false,
    themes: null,
    witnesses: null,
    hearings: null,
    displayHearing: false,
    selectedHearing: null,
    displayVideo: false,
    videoToWatch: '',
    scrollToVideo: false
};

function sortWitnessArray(a, b) {
    return b[0].localeCompare(a[0], 'en', {numeric: true, sensitivity: 'base'});
}

function loadThemes(hearingsData) {
    let themes;
    if (hearingsData.themes === undefined) {
        cl('NO THEMES', WARNING_CSS);
        themes = new Map();
    } else {
        themes = new Map(hearingsData.themes);
    }
    themes = new Map([...themes.entries()].sort((a, b) => a[1].localeCompare(b[1])));
    return themes;
}

function loadWitnesses(hearingsData) {
    let witnesses;
    if (hearingsData.witnesses === undefined) {
        cl('NO WITNESSES', WARNING_CSS);
        witnesses = new Map();
    } else {
        witnesses = new Map(hearingsData.witnesses);
    }
    witnesses = new Map([...witnesses.entries()].sort((a, b) => a[1].lastName.localeCompare(b[1].lastName)));
    return witnesses;
}

function selectHearing(id) {
    if (state.hearings.has(id)) {
        state.selectedHearing = state.hearings.get(id);
        cl('SELECT HEARING', SUCCESS_CSS);
    } else {
        cl('HEARING NOT FOUND', WARNING_CSS);
    }
}

function showHearing() {
    state.displayHearing = true;
    cl('DISPLAY HEARING', SUCCESS_CSS);
}

function hideHearing() {
  state.displayHearing = false;
  state.scrollToVideo = false;
  state.displayVideo = false;
  state.videoToWatch = '';
  cl('HIDE HEARING', SUCCESS_CSS);
}

function playVideo(videoId) {
    state.videoToWatch = videoId;
    cl('PLAY VIDEO', SUCCESS_CSS);
}

function showHideVideo(showVideo) {
    state.displayVideo = showVideo;
    if (state.displayVideo) {
        cl('SHOW VIDEO', SUCCESS_CSS);
    } else {
        cl('HIDE VIDEO', SUCCESS_CSS);
    }
}

function scrollToVideo() {
    state.scrollToVideo = true;
    cl('SCROLLING VIDEO', SUCCESS_CSS);
}

function deSelectHearing() {
  state.selectedHearing = null;
  state.scrollToVideo = false;
  state.displayVideo = false;
  state.videoToWatch = '';
  cl('DESELECTED HEARING', SUCCESS_CSS);
}

const CALENDAR = 'CALENDAR';
const EDITOR = 'EDITOR';
const EXHIBITS = 'EXHIBITS';
const MINI = 'MINI';

let visibleSlides;

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



/*  IS MOBILE  */

var UAParser = (function(window,undefined){"use strict";var LIBVERSION="0.7.21",EMPTY="",UNKNOWN="?",FUNC_TYPE="function",UNDEF_TYPE="undefined",OBJ_TYPE="object",STR_TYPE="string",MAJOR="major",MODEL="model",NAME="name",TYPE="type",VENDOR="vendor",VERSION="version",ARCHITECTURE="architecture",CONSOLE="console",MOBILE="mobile",TABLET="tablet",SMARTTV="smarttv",WEARABLE="wearable",EMBEDDED="embedded";var util={extend:function(regexes,extensions){var mergedRegexes={};for(var i in regexes){if(extensions[i]&&extensions[i].length%2===0){mergedRegexes[i]=extensions[i].concat(regexes[i])}else{mergedRegexes[i]=regexes[i]}}return mergedRegexes},has:function(str1,str2){if(typeof str1==="string"){return str2.toLowerCase().indexOf(str1.toLowerCase())!==-1}else{return false}},lowerize:function(str){return str.toLowerCase()},major:function(version){return typeof version===STR_TYPE?version.replace(/[^\d\.]/g,"").split(".")[0]:undefined},trim:function(str){return str.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g,"")}};var mapper={rgx:function(ua,arrays){var i=0,j,k,p,q,matches,match;while(i<arrays.length&&!matches){var regex=arrays[i],props=arrays[i+1];j=k=0;while(j<regex.length&&!matches){matches=regex[j++].exec(ua);if(!!matches){for(p=0;p<props.length;p++){match=matches[++k];q=props[p];if(typeof q===OBJ_TYPE&&q.length>0){if(q.length==2){if(typeof q[1]==FUNC_TYPE){this[q[0]]=q[1].call(this,match)}else{this[q[0]]=q[1]}}else if(q.length==3){if(typeof q[1]===FUNC_TYPE&&!(q[1].exec&&q[1].test)){this[q[0]]=match?q[1].call(this,match,q[2]):undefined}else{this[q[0]]=match?match.replace(q[1],q[2]):undefined}}else if(q.length==4){this[q[0]]=match?q[3].call(this,match.replace(q[1],q[2])):undefined}}else{this[q]=match?match:undefined}}}}i+=2}},str:function(str,map){for(var i in map){if(typeof map[i]===OBJ_TYPE&&map[i].length>0){for(var j=0;j<map[i].length;j++){if(util.has(map[i][j],str)){return i===UNKNOWN?undefined:i}}}else if(util.has(map[i],str)){return i===UNKNOWN?undefined:i}}return str}};var maps={browser:{oldsafari:{version:{"1.0":"/8",1.2:"/1",1.3:"/3","2.0":"/412","2.0.2":"/416","2.0.3":"/417","2.0.4":"/419","?":"/"}}},device:{amazon:{model:{"Fire Phone":["SD","KF"]}},sprint:{model:{"Evo Shift 4G":"7373KT"},vendor:{HTC:"APA",Sprint:"Sprint"}}},os:{windows:{version:{ME:"4.90","NT 3.11":"NT3.51","NT 4.0":"NT4.0",2000:"NT 5.0",XP:["NT 5.1","NT 5.2"],Vista:"NT 6.0",7:"NT 6.1",8:"NT 6.2",8.1:"NT 6.3",10:["NT 6.4","NT 10.0"],RT:"ARM"}}}};var regexes={browser:[[/(opera\smini)\/([\w\.-]+)/i,/(opera\s[mobiletab]+).+version\/([\w\.-]+)/i,/(opera).+version\/([\w\.]+)/i,/(opera)[\/\s]+([\w\.]+)/i],[NAME,VERSION],[/(opios)[\/\s]+([\w\.]+)/i],[[NAME,"Opera Mini"],VERSION],[/\s(opr)\/([\w\.]+)/i],[[NAME,"Opera"],VERSION],[/(kindle)\/([\w\.]+)/i,/(lunascape|maxthon|netfront|jasmine|blazer)[\/\s]?([\w\.]*)/i,/(avant\s|iemobile|slim)(?:browser)?[\/\s]?([\w\.]*)/i,/(bidubrowser|baidubrowser)[\/\s]?([\w\.]+)/i,/(?:ms|\()(ie)\s([\w\.]+)/i,/(rekonq)\/([\w\.]*)/i,/(chromium|flock|rockmelt|midori|epiphany|silk|skyfire|ovibrowser|bolt|iron|vivaldi|iridium|phantomjs|bowser|quark|qupzilla|falkon)\/([\w\.-]+)/i],[NAME,VERSION],[/(konqueror)\/([\w\.]+)/i],[[NAME,"Konqueror"],VERSION],[/(trident).+rv[:\s]([\w\.]+).+like\sgecko/i],[[NAME,"IE"],VERSION],[/(edge|edgios|edga|edg)\/((\d+)?[\w\.]+)/i],[[NAME,"Edge"],VERSION],[/(yabrowser)\/([\w\.]+)/i],[[NAME,"Yandex"],VERSION],[/(Avast)\/([\w\.]+)/i],[[NAME,"Avast Secure Browser"],VERSION],[/(AVG)\/([\w\.]+)/i],[[NAME,"AVG Secure Browser"],VERSION],[/(puffin)\/([\w\.]+)/i],[[NAME,"Puffin"],VERSION],[/(focus)\/([\w\.]+)/i],[[NAME,"Firefox Focus"],VERSION],[/(opt)\/([\w\.]+)/i],[[NAME,"Opera Touch"],VERSION],[/((?:[\s\/])uc?\s?browser|(?:juc.+)ucweb)[\/\s]?([\w\.]+)/i],[[NAME,"UCBrowser"],VERSION],[/(comodo_dragon)\/([\w\.]+)/i],[[NAME,/_/g," "],VERSION],[/(windowswechat qbcore)\/([\w\.]+)/i],[[NAME,"WeChat(Win) Desktop"],VERSION],[/(micromessenger)\/([\w\.]+)/i],[[NAME,"WeChat"],VERSION],[/(brave)\/([\w\.]+)/i],[[NAME,"Brave"],VERSION],[/(qqbrowserlite)\/([\w\.]+)/i],[NAME,VERSION],[/(QQ)\/([\d\.]+)/i],[NAME,VERSION],[/m?(qqbrowser)[\/\s]?([\w\.]+)/i],[NAME,VERSION],[/(baiduboxapp)[\/\s]?([\w\.]+)/i],[NAME,VERSION],[/(2345Explorer)[\/\s]?([\w\.]+)/i],[NAME,VERSION],[/(MetaSr)[\/\s]?([\w\.]+)/i],[NAME],[/(LBBROWSER)/i],[NAME],[/xiaomi\/miuibrowser\/([\w\.]+)/i],[VERSION,[NAME,"MIUI Browser"]],[/;fbav\/([\w\.]+);/i],[VERSION,[NAME,"Facebook"]],[/safari\s(line)\/([\w\.]+)/i,/android.+(line)\/([\w\.]+)\/iab/i],[NAME,VERSION],[/headlesschrome(?:\/([\w\.]+)|\s)/i],[VERSION,[NAME,"Chrome Headless"]],[/\swv\).+(chrome)\/([\w\.]+)/i],[[NAME,/(.+)/,"$1 WebView"],VERSION],[/((?:oculus|samsung)browser)\/([\w\.]+)/i],[[NAME,/(.+(?:g|us))(.+)/,"$1 $2"],VERSION],[/android.+version\/([\w\.]+)\s+(?:mobile\s?safari|safari)*/i],[VERSION,[NAME,"Android Browser"]],[/(sailfishbrowser)\/([\w\.]+)/i],[[NAME,"Sailfish Browser"],VERSION],[/(chrome|omniweb|arora|[tizenoka]{5}\s?browser)\/v?([\w\.]+)/i],[NAME,VERSION],[/(dolfin)\/([\w\.]+)/i],[[NAME,"Dolphin"],VERSION],[/(qihu|qhbrowser|qihoobrowser|360browser)/i],[[NAME,"360 Browser"]],[/((?:android.+)crmo|crios)\/([\w\.]+)/i],[[NAME,"Chrome"],VERSION],[/(coast)\/([\w\.]+)/i],[[NAME,"Opera Coast"],VERSION],[/fxios\/([\w\.-]+)/i],[VERSION,[NAME,"Firefox"]],[/version\/([\w\.]+).+?mobile\/\w+\s(safari)/i],[VERSION,[NAME,"Mobile Safari"]],[/version\/([\w\.]+).+?(mobile\s?safari|safari)/i],[VERSION,NAME],[/webkit.+?(gsa)\/([\w\.]+).+?(mobile\s?safari|safari)(\/[\w\.]+)/i],[[NAME,"GSA"],VERSION],[/webkit.+?(mobile\s?safari|safari)(\/[\w\.]+)/i],[NAME,[VERSION,mapper.str,maps.browser.oldsafari.version]],[/(webkit|khtml)\/([\w\.]+)/i],[NAME,VERSION],[/(navigator|netscape)\/([\w\.-]+)/i],[[NAME,"Netscape"],VERSION],[/(swiftfox)/i,/(icedragon|iceweasel|camino|chimera|fennec|maemo\sbrowser|minimo|conkeror)[\/\s]?([\w\.\+]+)/i,/(firefox|seamonkey|k-meleon|icecat|iceape|firebird|phoenix|palemoon|basilisk|waterfox)\/([\w\.-]+)$/i,/(mozilla)\/([\w\.]+).+rv\:.+gecko\/\d+/i,/(polaris|lynx|dillo|icab|doris|amaya|w3m|netsurf|sleipnir)[\/\s]?([\w\.]+)/i,/(links)\s\(([\w\.]+)/i,/(gobrowser)\/?([\w\.]*)/i,/(ice\s?browser)\/v?([\w\._]+)/i,/(mosaic)[\/\s]([\w\.]+)/i],[NAME,VERSION]],cpu:[[/(?:(amd|x(?:(?:86|64)[_-])?|wow|win)64)[;\)]/i],[[ARCHITECTURE,"amd64"]],[/(ia32(?=;))/i],[[ARCHITECTURE,util.lowerize]],[/((?:i[346]|x)86)[;\)]/i],[[ARCHITECTURE,"ia32"]],[/windows\s(ce|mobile);\sppc;/i],[[ARCHITECTURE,"arm"]],[/((?:ppc|powerpc)(?:64)?)(?:\smac|;|\))/i],[[ARCHITECTURE,/ower/,"",util.lowerize]],[/(sun4\w)[;\)]/i],[[ARCHITECTURE,"sparc"]],[/((?:avr32|ia64(?=;))|68k(?=\))|arm(?:64|(?=v\d+[;l]))|(?=atmel\s)avr|(?:irix|mips|sparc)(?:64)?(?=;)|pa-risc)/i],[[ARCHITECTURE,util.lowerize]]],device:[[/\((ipad|playbook);[\w\s\),;-]+(rim|apple)/i],[MODEL,VENDOR,[TYPE,TABLET]],[/applecoremedia\/[\w\.]+ \((ipad)/],[MODEL,[VENDOR,"Apple"],[TYPE,TABLET]],[/(apple\s{0,1}tv)/i],[[MODEL,"Apple TV"],[VENDOR,"Apple"],[TYPE,SMARTTV]],[/(archos)\s(gamepad2?)/i,/(hp).+(touchpad)/i,/(hp).+(tablet)/i,/(kindle)\/([\w\.]+)/i,/\s(nook)[\w\s]+build\/(\w+)/i,/(dell)\s(strea[kpr\s\d]*[\dko])/i],[VENDOR,MODEL,[TYPE,TABLET]],[/(kf[A-z]+)\sbuild\/.+silk\//i],[MODEL,[VENDOR,"Amazon"],[TYPE,TABLET]],[/(sd|kf)[0349hijorstuw]+\sbuild\/.+silk\//i],[[MODEL,mapper.str,maps.device.amazon.model],[VENDOR,"Amazon"],[TYPE,MOBILE]],[/android.+aft([bms])\sbuild/i],[MODEL,[VENDOR,"Amazon"],[TYPE,SMARTTV]],[/\((ip[honed|\s\w*]+);.+(apple)/i],[MODEL,VENDOR,[TYPE,MOBILE]],[/\((ip[honed|\s\w*]+);/i],[MODEL,[VENDOR,"Apple"],[TYPE,MOBILE]],[/(blackberry)[\s-]?(\w+)/i,/(blackberry|benq|palm(?=\-)|sonyericsson|acer|asus|dell|meizu|motorola|polytron)[\s_-]?([\w-]*)/i,/(hp)\s([\w\s]+\w)/i,/(asus)-?(\w+)/i],[VENDOR,MODEL,[TYPE,MOBILE]],[/\(bb10;\s(\w+)/i],[MODEL,[VENDOR,"BlackBerry"],[TYPE,MOBILE]],[/android.+(transfo[prime\s]{4,10}\s\w+|eeepc|slider\s\w+|nexus 7|padfone|p00c)/i],[MODEL,[VENDOR,"Asus"],[TYPE,TABLET]],[/(sony)\s(tablet\s[ps])\sbuild\//i,/(sony)?(?:sgp.+)\sbuild\//i],[[VENDOR,"Sony"],[MODEL,"Xperia Tablet"],[TYPE,TABLET]],[/android.+\s([c-g]\d{4}|so[-l]\w+)(?=\sbuild\/|\).+chrome\/(?![1-6]{0,1}\d\.))/i],[MODEL,[VENDOR,"Sony"],[TYPE,MOBILE]],[/\s(ouya)\s/i,/(nintendo)\s([wids3u]+)/i],[VENDOR,MODEL,[TYPE,CONSOLE]],[/android.+;\s(shield)\sbuild/i],[MODEL,[VENDOR,"Nvidia"],[TYPE,CONSOLE]],[/(playstation\s[34portablevi]+)/i],[MODEL,[VENDOR,"Sony"],[TYPE,CONSOLE]],[/(sprint\s(\w+))/i],[[VENDOR,mapper.str,maps.device.sprint.vendor],[MODEL,mapper.str,maps.device.sprint.model],[TYPE,MOBILE]],[/(htc)[;_\s-]+([\w\s]+(?=\)|\sbuild)|\w+)/i,/(zte)-(\w*)/i,/(alcatel|geeksphone|nexian|panasonic|(?=;\s)sony)[_\s-]?([\w-]*)/i],[VENDOR,[MODEL,/_/g," "],[TYPE,MOBILE]],[/(nexus\s9)/i],[MODEL,[VENDOR,"HTC"],[TYPE,TABLET]],[/d\/huawei([\w\s-]+)[;\)]/i,/(nexus\s6p|vog-l29|ane-lx1|eml-l29)/i],[MODEL,[VENDOR,"Huawei"],[TYPE,MOBILE]],[/android.+(bah2?-a?[lw]\d{2})/i],[MODEL,[VENDOR,"Huawei"],[TYPE,TABLET]],[/(microsoft);\s(lumia[\s\w]+)/i],[VENDOR,MODEL,[TYPE,MOBILE]],[/[\s\(;](xbox(?:\sone)?)[\s\);]/i],[MODEL,[VENDOR,"Microsoft"],[TYPE,CONSOLE]],[/(kin\.[onetw]{3})/i],[[MODEL,/\./g," "],[VENDOR,"Microsoft"],[TYPE,MOBILE]],[/\s(milestone|droid(?:[2-4x]|\s(?:bionic|x2|pro|razr))?:?(\s4g)?)[\w\s]+build\//i,/mot[\s-]?(\w*)/i,/(XT\d{3,4}) build\//i,/(nexus\s6)/i],[MODEL,[VENDOR,"Motorola"],[TYPE,MOBILE]],[/android.+\s(mz60\d|xoom[\s2]{0,2})\sbuild\//i],[MODEL,[VENDOR,"Motorola"],[TYPE,TABLET]],[/hbbtv\/\d+\.\d+\.\d+\s+\([\w\s]*;\s*(\w[^;]*);([^;]*)/i],[[VENDOR,util.trim],[MODEL,util.trim],[TYPE,SMARTTV]],[/hbbtv.+maple;(\d+)/i],[[MODEL,/^/,"SmartTV"],[VENDOR,"Samsung"],[TYPE,SMARTTV]],[/\(dtv[\);].+(aquos)/i],[MODEL,[VENDOR,"Sharp"],[TYPE,SMARTTV]],[/android.+((sch-i[89]0\d|shw-m380s|gt-p\d{4}|gt-n\d+|sgh-t8[56]9|nexus 10))/i,/((SM-T\w+))/i],[[VENDOR,"Samsung"],MODEL,[TYPE,TABLET]],[/smart-tv.+(samsung)/i],[VENDOR,[TYPE,SMARTTV],MODEL],[/((s[cgp]h-\w+|gt-\w+|galaxy\snexus|sm-\w[\w\d]+))/i,/(sam[sung]*)[\s-]*(\w+-?[\w-]*)/i,/sec-((sgh\w+))/i],[[VENDOR,"Samsung"],MODEL,[TYPE,MOBILE]],[/sie-(\w*)/i],[MODEL,[VENDOR,"Siemens"],[TYPE,MOBILE]],[/(maemo|nokia).*(n900|lumia\s\d+)/i,/(nokia)[\s_-]?([\w-]*)/i],[[VENDOR,"Nokia"],MODEL,[TYPE,MOBILE]],[/android[x\d\.\s;]+\s([ab][1-7]\-?[0178a]\d\d?)/i],[MODEL,[VENDOR,"Acer"],[TYPE,TABLET]],[/android.+([vl]k\-?\d{3})\s+build/i],[MODEL,[VENDOR,"LG"],[TYPE,TABLET]],[/android\s3\.[\s\w;-]{10}(lg?)-([06cv9]{3,4})/i],[[VENDOR,"LG"],MODEL,[TYPE,TABLET]],[/(lg) netcast\.tv/i],[VENDOR,MODEL,[TYPE,SMARTTV]],[/(nexus\s[45])/i,/lg[e;\s\/-]+(\w*)/i,/android.+lg(\-?[\d\w]+)\s+build/i],[MODEL,[VENDOR,"LG"],[TYPE,MOBILE]],[/(lenovo)\s?(s(?:5000|6000)(?:[\w-]+)|tab(?:[\s\w]+))/i],[VENDOR,MODEL,[TYPE,TABLET]],[/android.+(ideatab[a-z0-9\-\s]+)/i],[MODEL,[VENDOR,"Lenovo"],[TYPE,TABLET]],[/(lenovo)[_\s-]?([\w-]+)/i],[VENDOR,MODEL,[TYPE,MOBILE]],[/linux;.+((jolla));/i],[VENDOR,MODEL,[TYPE,MOBILE]],[/((pebble))app\/[\d\.]+\s/i],[VENDOR,MODEL,[TYPE,WEARABLE]],[/android.+;\s(oppo)\s?([\w\s]+)\sbuild/i],[VENDOR,MODEL,[TYPE,MOBILE]],[/crkey/i],[[MODEL,"Chromecast"],[VENDOR,"Google"],[TYPE,SMARTTV]],[/android.+;\s(glass)\s\d/i],[MODEL,[VENDOR,"Google"],[TYPE,WEARABLE]],[/android.+;\s(pixel c)[\s)]/i],[MODEL,[VENDOR,"Google"],[TYPE,TABLET]],[/android.+;\s(pixel( [23])?( xl)?)[\s)]/i],[MODEL,[VENDOR,"Google"],[TYPE,MOBILE]],[/android.+;\s(\w+)\s+build\/hm\1/i,/android.+(hm[\s\-_]*note?[\s_]*(?:\d\w)?)\s+build/i,/android.+(mi[\s\-_]*(?:a\d|one|one[\s_]plus|note lte)?[\s_]*(?:\d?\w?)[\s_]*(?:plus)?)\s+build/i,/android.+(redmi[\s\-_]*(?:note)?(?:[\s_]*[\w\s]+))\s+build/i],[[MODEL,/_/g," "],[VENDOR,"Xiaomi"],[TYPE,MOBILE]],[/android.+(mi[\s\-_]*(?:pad)(?:[\s_]*[\w\s]+))\s+build/i],[[MODEL,/_/g," "],[VENDOR,"Xiaomi"],[TYPE,TABLET]],[/android.+;\s(m[1-5]\snote)\sbuild/i],[MODEL,[VENDOR,"Meizu"],[TYPE,MOBILE]],[/(mz)-([\w-]{2,})/i],[[VENDOR,"Meizu"],MODEL,[TYPE,MOBILE]],[/android.+a000(1)\s+build/i,/android.+oneplus\s(a\d{4})[\s)]/i],[MODEL,[VENDOR,"OnePlus"],[TYPE,MOBILE]],[/android.+[;\/]\s*(RCT[\d\w]+)\s+build/i],[MODEL,[VENDOR,"RCA"],[TYPE,TABLET]],[/android.+[;\/\s]+(Venue[\d\s]{2,7})\s+build/i],[MODEL,[VENDOR,"Dell"],[TYPE,TABLET]],[/android.+[;\/]\s*(Q[T|M][\d\w]+)\s+build/i],[MODEL,[VENDOR,"Verizon"],[TYPE,TABLET]],[/android.+[;\/]\s+(Barnes[&\s]+Noble\s+|BN[RT])(V?.*)\s+build/i],[[VENDOR,"Barnes & Noble"],MODEL,[TYPE,TABLET]],[/android.+[;\/]\s+(TM\d{3}.*\b)\s+build/i],[MODEL,[VENDOR,"NuVision"],[TYPE,TABLET]],[/android.+;\s(k88)\sbuild/i],[MODEL,[VENDOR,"ZTE"],[TYPE,TABLET]],[/android.+[;\/]\s*(gen\d{3})\s+build.*49h/i],[MODEL,[VENDOR,"Swiss"],[TYPE,MOBILE]],[/android.+[;\/]\s*(zur\d{3})\s+build/i],[MODEL,[VENDOR,"Swiss"],[TYPE,TABLET]],[/android.+[;\/]\s*((Zeki)?TB.*\b)\s+build/i],[MODEL,[VENDOR,"Zeki"],[TYPE,TABLET]],[/(android).+[;\/]\s+([YR]\d{2})\s+build/i,/android.+[;\/]\s+(Dragon[\-\s]+Touch\s+|DT)(\w{5})\sbuild/i],[[VENDOR,"Dragon Touch"],MODEL,[TYPE,TABLET]],[/android.+[;\/]\s*(NS-?\w{0,9})\sbuild/i],[MODEL,[VENDOR,"Insignia"],[TYPE,TABLET]],[/android.+[;\/]\s*((NX|Next)-?\w{0,9})\s+build/i],[MODEL,[VENDOR,"NextBook"],[TYPE,TABLET]],[/android.+[;\/]\s*(Xtreme\_)?(V(1[045]|2[015]|30|40|60|7[05]|90))\s+build/i],[[VENDOR,"Voice"],MODEL,[TYPE,MOBILE]],[/android.+[;\/]\s*(LVTEL\-)?(V1[12])\s+build/i],[[VENDOR,"LvTel"],MODEL,[TYPE,MOBILE]],[/android.+;\s(PH-1)\s/i],[MODEL,[VENDOR,"Essential"],[TYPE,MOBILE]],[/android.+[;\/]\s*(V(100MD|700NA|7011|917G).*\b)\s+build/i],[MODEL,[VENDOR,"Envizen"],[TYPE,TABLET]],[/android.+[;\/]\s*(Le[\s\-]+Pan)[\s\-]+(\w{1,9})\s+build/i],[VENDOR,MODEL,[TYPE,TABLET]],[/android.+[;\/]\s*(Trio[\s\-]*.*)\s+build/i],[MODEL,[VENDOR,"MachSpeed"],[TYPE,TABLET]],[/android.+[;\/]\s*(Trinity)[\-\s]*(T\d{3})\s+build/i],[VENDOR,MODEL,[TYPE,TABLET]],[/android.+[;\/]\s*TU_(1491)\s+build/i],[MODEL,[VENDOR,"Rotor"],[TYPE,TABLET]],[/android.+(KS(.+))\s+build/i],[MODEL,[VENDOR,"Amazon"],[TYPE,TABLET]],[/android.+(Gigaset)[\s\-]+(Q\w{1,9})\s+build/i],[VENDOR,MODEL,[TYPE,TABLET]],[/\s(tablet|tab)[;\/]/i,/\s(mobile)(?:[;\/]|\ssafari)/i],[[TYPE,util.lowerize],VENDOR,MODEL],[/[\s\/\(](smart-?tv)[;\)]/i],[[TYPE,SMARTTV]],[/(android[\w\.\s\-]{0,9});.+build/i],[MODEL,[VENDOR,"Generic"]]],engine:[[/windows.+\sedge\/([\w\.]+)/i],[VERSION,[NAME,"EdgeHTML"]],[/webkit\/537\.36.+chrome\/(?!27)([\w\.]+)/i],[VERSION,[NAME,"Blink"]],[/(presto)\/([\w\.]+)/i,/(webkit|trident|netfront|netsurf|amaya|lynx|w3m|goanna)\/([\w\.]+)/i,/(khtml|tasman|links)[\/\s]\(?([\w\.]+)/i,/(icab)[\/\s]([23]\.[\d\.]+)/i],[NAME,VERSION],[/rv\:([\w\.]{1,9}).+(gecko)/i],[VERSION,NAME]],os:[[/microsoft\s(windows)\s(vista|xp)/i],[NAME,VERSION],[/(windows)\snt\s6\.2;\s(arm)/i,/(windows\sphone(?:\sos)*)[\s\/]?([\d\.\s\w]*)/i,/(windows\smobile|windows)[\s\/]?([ntce\d\.\s]+\w)/i],[NAME,[VERSION,mapper.str,maps.os.windows.version]],[/(win(?=3|9|n)|win\s9x\s)([nt\d\.]+)/i],[[NAME,"Windows"],[VERSION,mapper.str,maps.os.windows.version]],[/\((bb)(10);/i],[[NAME,"BlackBerry"],VERSION],[/(blackberry)\w*\/?([\w\.]*)/i,/(tizen|kaios)[\/\s]([\w\.]+)/i,/(android|webos|palm\sos|qnx|bada|rim\stablet\sos|meego|sailfish|contiki)[\/\s-]?([\w\.]*)/i],[NAME,VERSION],[/(symbian\s?os|symbos|s60(?=;))[\/\s-]?([\w\.]*)/i],[[NAME,"Symbian"],VERSION],[/\((series40);/i],[NAME],[/mozilla.+\(mobile;.+gecko.+firefox/i],[[NAME,"Firefox OS"],VERSION],[/(nintendo|playstation)\s([wids34portablevu]+)/i,/(mint)[\/\s\(]?(\w*)/i,/(mageia|vectorlinux)[;\s]/i,/(joli|[kxln]?ubuntu|debian|suse|opensuse|gentoo|(?=\s)arch|slackware|fedora|mandriva|centos|pclinuxos|redhat|zenwalk|linpus)[\/\s-]?(?!chrom)([\w\.-]*)/i,/(hurd|linux)\s?([\w\.]*)/i,/(gnu)\s?([\w\.]*)/i],[NAME,VERSION],[/(cros)\s[\w]+\s([\w\.]+\w)/i],[[NAME,"Chromium OS"],VERSION],[/(sunos)\s?([\w\.\d]*)/i],[[NAME,"Solaris"],VERSION],[/\s([frentopc-]{0,4}bsd|dragonfly)\s?([\w\.]*)/i],[NAME,VERSION],[/(haiku)\s(\w+)/i],[NAME,VERSION],[/cfnetwork\/.+darwin/i,/ip[honead]{2,4}(?:.*os\s([\w]+)\slike\smac|;\sopera)/i],[[VERSION,/_/g,"."],[NAME,"iOS"]],[/(mac\sos\sx)\s?([\w\s\.]*)/i,/(macintosh|mac(?=_powerpc)\s)/i],[[NAME,"Mac OS"],[VERSION,/_/g,"."]],[/((?:open)?solaris)[\/\s-]?([\w\.]*)/i,/(aix)\s((\d)(?=\.|\)|\s)[\w\.])*/i,/(plan\s9|minix|beos|os\/2|amigaos|morphos|risc\sos|openvms|fuchsia)/i,/(unix)\s?([\w\.]*)/i],[NAME,VERSION]]};var UAParser=function(uastring,extensions){if(typeof uastring==="object"){extensions=uastring;uastring=undefined}if(!(this instanceof UAParser)){return new UAParser(uastring,extensions).getResult()}var ua=uastring||(window&&window.navigator&&window.navigator.userAgent?window.navigator.userAgent:EMPTY);var rgxmap=extensions?util.extend(regexes,extensions):regexes;this.getBrowser=function(){var browser={name:undefined,version:undefined};mapper.rgx.call(browser,ua,rgxmap.browser);browser.major=util.major(browser.version);return browser};this.getCPU=function(){var cpu={architecture:undefined};mapper.rgx.call(cpu,ua,rgxmap.cpu);return cpu};this.getDevice=function(){var device={vendor:undefined,model:undefined,type:undefined};mapper.rgx.call(device,ua,rgxmap.device);return device};this.getEngine=function(){var engine={name:undefined,version:undefined};mapper.rgx.call(engine,ua,rgxmap.engine);return engine};this.getOS=function(){var os={name:undefined,version:undefined};mapper.rgx.call(os,ua,rgxmap.os);return os};this.getResult=function(){return{ua:this.getUA(),browser:this.getBrowser(),engine:this.getEngine(),os:this.getOS(),device:this.getDevice(),cpu:this.getCPU()}};this.getUA=function(){return ua};this.setUA=function(uastring){ua=uastring;return this};return this};UAParser.VERSION=LIBVERSION;UAParser.BROWSER={NAME:NAME,MAJOR:MAJOR,VERSION:VERSION};UAParser.CPU={ARCHITECTURE:ARCHITECTURE};UAParser.DEVICE={MODEL:MODEL,VENDOR:VENDOR,TYPE:TYPE,CONSOLE:CONSOLE,MOBILE:MOBILE,SMARTTV:SMARTTV,TABLET:TABLET,WEARABLE:WEARABLE,EMBEDDED:EMBEDDED};UAParser.ENGINE={NAME:NAME,VERSION:VERSION};UAParser.OS={NAME:NAME,VERSION:VERSION};if(typeof exports!==UNDEF_TYPE){if(typeof module!==UNDEF_TYPE&&module.exports){exports=module.exports=UAParser}exports.UAParser=UAParser}else{if(typeof define==="function"&&define.amd){define(function(){return UAParser})}else if(window){window.UAParser=UAParser}}var $=window&&(window.jQuery||window.Zepto);if($&&!$.ua){var parser=new UAParser;$.ua=parser.getResult();$.ua.get=function(){return parser.getUA()};$.ua.set=function(uastring){parser.setUA(uastring);var result=parser.getResult();for(var prop in result){$.ua[prop]=result[prop]}}}})(typeof window==="object"?window:this);


!function(i,s){"use strict";var e="0.7.21",o="",r="?",a="function",n="undefined",d="object",t="string",w="major",l="model",u="name",c="type",b="vendor",m="version",p="architecture",g="console",f="mobile",h="tablet",v="smarttv",x="wearable",k="embedded",y={extend:function(i,s){var e={};for(var o in i)s[o]&&s[o].length%2===0?e[o]=s[o].concat(i[o]):e[o]=i[o];return e},has:function(i,s){return"string"==typeof i&&s.toLowerCase().indexOf(i.toLowerCase())!==-1},lowerize:function(i){return i.toLowerCase()},major:function(i){return typeof i===t?i.replace(/[^\d\.]/g,"").split(".")[0]:s},trim:function(i){return i.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g,"")}},T={rgx:function(i,e){for(var o,r,n,t,w,l,u=0;u<e.length&&!w;){var c=e[u],b=e[u+1];for(o=r=0;o<c.length&&!w;)if(w=c[o++].exec(i))for(n=0;n<b.length;n++)l=w[++r],t=b[n],typeof t===d&&t.length>0?2==t.length?typeof t[1]==a?this[t[0]]=t[1].call(this,l):this[t[0]]=t[1]:3==t.length?typeof t[1]!==a||t[1].exec&&t[1].test?this[t[0]]=l?l.replace(t[1],t[2]):s:this[t[0]]=l?t[1].call(this,l,t[2]):s:4==t.length&&(this[t[0]]=l?t[3].call(this,l.replace(t[1],t[2])):s):this[t]=l?l:s;u+=2}},str:function(i,e){for(var o in e)if(typeof e[o]===d&&e[o].length>0){for(var a=0;a<e[o].length;a++)if(y.has(e[o][a],i))return o===r?s:o}else if(y.has(e[o],i))return o===r?s:o;return i}},A={browser:{oldsafari:{version:{"1.0":"/8",1.2:"/1",1.3:"/3","2.0":"/412","2.0.2":"/416","2.0.3":"/417","2.0.4":"/419","?":"/"}}},device:{amazon:{model:{"Fire Phone":["SD","KF"]}},sprint:{model:{"Evo Shift 4G":"7373KT"},vendor:{HTC:"APA",Sprint:"Sprint"}}},os:{windows:{version:{ME:"4.90","NT 3.11":"NT3.51","NT 4.0":"NT4.0",2000:"NT 5.0",XP:["NT 5.1","NT 5.2"],Vista:"NT 6.0",7:"NT 6.1",8:"NT 6.2",8.1:"NT 6.3",10:["NT 6.4","NT 10.0"],RT:"ARM"}}}},S={browser:[[/(opera\smini)\/([\w\.-]+)/i,/(opera\s[mobiletab]+).+version\/([\w\.-]+)/i,/(opera).+version\/([\w\.]+)/i,/(opera)[\/\s]+([\w\.]+)/i],[u,m],[/(opios)[\/\s]+([\w\.]+)/i],[[u,"Opera Mini"],m],[/\s(opr)\/([\w\.]+)/i],[[u,"Opera"],m],[/(kindle)\/([\w\.]+)/i,/(lunascape|maxthon|netfront|jasmine|blazer)[\/\s]?([\w\.]*)/i,/(avant\s|iemobile|slim)(?:browser)?[\/\s]?([\w\.]*)/i,/(bidubrowser|baidubrowser)[\/\s]?([\w\.]+)/i,/(?:ms|\()(ie)\s([\w\.]+)/i,/(rekonq)\/([\w\.]*)/i,/(chromium|flock|rockmelt|midori|epiphany|silk|skyfire|ovibrowser|bolt|iron|vivaldi|iridium|phantomjs|bowser|quark|qupzilla|falkon)\/([\w\.-]+)/i],[u,m],[/(konqueror)\/([\w\.]+)/i],[[u,"Konqueror"],m],[/(trident).+rv[:\s]([\w\.]+).+like\sgecko/i],[[u,"IE"],m],[/(edge|edgios|edga|edg)\/((\d+)?[\w\.]+)/i],[[u,"Edge"],m],[/(yabrowser)\/([\w\.]+)/i],[[u,"Yandex"],m],[/(Avast)\/([\w\.]+)/i],[[u,"Avast Secure Browser"],m],[/(AVG)\/([\w\.]+)/i],[[u,"AVG Secure Browser"],m],[/(puffin)\/([\w\.]+)/i],[[u,"Puffin"],m],[/(focus)\/([\w\.]+)/i],[[u,"Firefox Focus"],m],[/(opt)\/([\w\.]+)/i],[[u,"Opera Touch"],m],[/((?:[\s\/])uc?\s?browser|(?:juc.+)ucweb)[\/\s]?([\w\.]+)/i],[[u,"UCBrowser"],m],[/(comodo_dragon)\/([\w\.]+)/i],[[u,/_/g," "],m],[/(windowswechat qbcore)\/([\w\.]+)/i],[[u,"WeChat(Win) Desktop"],m],[/(micromessenger)\/([\w\.]+)/i],[[u,"WeChat"],m],[/(brave)\/([\w\.]+)/i],[[u,"Brave"],m],[/(qqbrowserlite)\/([\w\.]+)/i],[u,m],[/(QQ)\/([\d\.]+)/i],[u,m],[/m?(qqbrowser)[\/\s]?([\w\.]+)/i],[u,m],[/(baiduboxapp)[\/\s]?([\w\.]+)/i],[u,m],[/(2345Explorer)[\/\s]?([\w\.]+)/i],[u,m],[/(MetaSr)[\/\s]?([\w\.]+)/i],[u],[/(LBBROWSER)/i],[u],[/xiaomi\/miuibrowser\/([\w\.]+)/i],[m,[u,"MIUI Browser"]],[/;fbav\/([\w\.]+);/i],[m,[u,"Facebook"]],[/safari\s(line)\/([\w\.]+)/i,/android.+(line)\/([\w\.]+)\/iab/i],[u,m],[/headlesschrome(?:\/([\w\.]+)|\s)/i],[m,[u,"Chrome Headless"]],[/\swv\).+(chrome)\/([\w\.]+)/i],[[u,/(.+)/,"$1 WebView"],m],[/((?:oculus|samsung)browser)\/([\w\.]+)/i],[[u,/(.+(?:g|us))(.+)/,"$1 $2"],m],[/android.+version\/([\w\.]+)\s+(?:mobile\s?safari|safari)*/i],[m,[u,"Android Browser"]],[/(sailfishbrowser)\/([\w\.]+)/i],[[u,"Sailfish Browser"],m],[/(chrome|omniweb|arora|[tizenoka]{5}\s?browser)\/v?([\w\.]+)/i],[u,m],[/(dolfin)\/([\w\.]+)/i],[[u,"Dolphin"],m],[/(qihu|qhbrowser|qihoobrowser|360browser)/i],[[u,"360 Browser"]],[/((?:android.+)crmo|crios)\/([\w\.]+)/i],[[u,"Chrome"],m],[/(coast)\/([\w\.]+)/i],[[u,"Opera Coast"],m],[/fxios\/([\w\.-]+)/i],[m,[u,"Firefox"]],[/version\/([\w\.]+).+?mobile\/\w+\s(safari)/i],[m,[u,"Mobile Safari"]],[/version\/([\w\.]+).+?(mobile\s?safari|safari)/i],[m,u],[/webkit.+?(gsa)\/([\w\.]+).+?(mobile\s?safari|safari)(\/[\w\.]+)/i],[[u,"GSA"],m],[/webkit.+?(mobile\s?safari|safari)(\/[\w\.]+)/i],[u,[m,T.str,A.browser.oldsafari.version]],[/(webkit|khtml)\/([\w\.]+)/i],[u,m],[/(navigator|netscape)\/([\w\.-]+)/i],[[u,"Netscape"],m],[/(swiftfox)/i,/(icedragon|iceweasel|camino|chimera|fennec|maemo\sbrowser|minimo|conkeror)[\/\s]?([\w\.\+]+)/i,/(firefox|seamonkey|k-meleon|icecat|iceape|firebird|phoenix|palemoon|basilisk|waterfox)\/([\w\.-]+)$/i,/(mozilla)\/([\w\.]+).+rv\:.+gecko\/\d+/i,/(polaris|lynx|dillo|icab|doris|amaya|w3m|netsurf|sleipnir)[\/\s]?([\w\.]+)/i,/(links)\s\(([\w\.]+)/i,/(gobrowser)\/?([\w\.]*)/i,/(ice\s?browser)\/v?([\w\._]+)/i,/(mosaic)[\/\s]([\w\.]+)/i],[u,m]],cpu:[[/(?:(amd|x(?:(?:86|64)[_-])?|wow|win)64)[;\)]/i],[[p,"amd64"]],[/(ia32(?=;))/i],[[p,y.lowerize]],[/((?:i[346]|x)86)[;\)]/i],[[p,"ia32"]],[/windows\s(ce|mobile);\sppc;/i],[[p,"arm"]],[/((?:ppc|powerpc)(?:64)?)(?:\smac|;|\))/i],[[p,/ower/,"",y.lowerize]],[/(sun4\w)[;\)]/i],[[p,"sparc"]],[/((?:avr32|ia64(?=;))|68k(?=\))|arm(?:64|(?=v\d+[;l]))|(?=atmel\s)avr|(?:irix|mips|sparc)(?:64)?(?=;)|pa-risc)/i],[[p,y.lowerize]]],device:[[/\((ipad|playbook);[\w\s\),;-]+(rim|apple)/i],[l,b,[c,h]],[/applecoremedia\/[\w\.]+ \((ipad)/],[l,[b,"Apple"],[c,h]],[/(apple\s{0,1}tv)/i],[[l,"Apple TV"],[b,"Apple"],[c,v]],[/(archos)\s(gamepad2?)/i,/(hp).+(touchpad)/i,/(hp).+(tablet)/i,/(kindle)\/([\w\.]+)/i,/\s(nook)[\w\s]+build\/(\w+)/i,/(dell)\s(strea[kpr\s\d]*[\dko])/i],[b,l,[c,h]],[/(kf[A-z]+)\sbuild\/.+silk\//i],[l,[b,"Amazon"],[c,h]],[/(sd|kf)[0349hijorstuw]+\sbuild\/.+silk\//i],[[l,T.str,A.device.amazon.model],[b,"Amazon"],[c,f]],[/android.+aft([bms])\sbuild/i],[l,[b,"Amazon"],[c,v]],[/\((ip[honed|\s\w*]+);.+(apple)/i],[l,b,[c,f]],[/\((ip[honed|\s\w*]+);/i],[l,[b,"Apple"],[c,f]],[/(blackberry)[\s-]?(\w+)/i,/(blackberry|benq|palm(?=\-)|sonyericsson|acer|asus|dell|meizu|motorola|polytron)[\s_-]?([\w-]*)/i,/(hp)\s([\w\s]+\w)/i,/(asus)-?(\w+)/i],[b,l,[c,f]],[/\(bb10;\s(\w+)/i],[l,[b,"BlackBerry"],[c,f]],[/android.+(transfo[prime\s]{4,10}\s\w+|eeepc|slider\s\w+|nexus 7|padfone|p00c)/i],[l,[b,"Asus"],[c,h]],[/(sony)\s(tablet\s[ps])\sbuild\//i,/(sony)?(?:sgp.+)\sbuild\//i],[[b,"Sony"],[l,"Xperia Tablet"],[c,h]],[/android.+\s([c-g]\d{4}|so[-l]\w+)(?=\sbuild\/|\).+chrome\/(?![1-6]{0,1}\d\.))/i],[l,[b,"Sony"],[c,f]],[/\s(ouya)\s/i,/(nintendo)\s([wids3u]+)/i],[b,l,[c,g]],[/android.+;\s(shield)\sbuild/i],[l,[b,"Nvidia"],[c,g]],[/(playstation\s[34portablevi]+)/i],[l,[b,"Sony"],[c,g]],[/(sprint\s(\w+))/i],[[b,T.str,A.device.sprint.vendor],[l,T.str,A.device.sprint.model],[c,f]],[/(htc)[;_\s-]+([\w\s]+(?=\)|\sbuild)|\w+)/i,/(zte)-(\w*)/i,/(alcatel|geeksphone|nexian|panasonic|(?=;\s)sony)[_\s-]?([\w-]*)/i],[b,[l,/_/g," "],[c,f]],[/(nexus\s9)/i],[l,[b,"HTC"],[c,h]],[/d\/huawei([\w\s-]+)[;\)]/i,/(nexus\s6p|vog-l29|ane-lx1|eml-l29)/i],[l,[b,"Huawei"],[c,f]],[/android.+(bah2?-a?[lw]\d{2})/i],[l,[b,"Huawei"],[c,h]],[/(microsoft);\s(lumia[\s\w]+)/i],[b,l,[c,f]],[/[\s\(;](xbox(?:\sone)?)[\s\);]/i],[l,[b,"Microsoft"],[c,g]],[/(kin\.[onetw]{3})/i],[[l,/\./g," "],[b,"Microsoft"],[c,f]],[/\s(milestone|droid(?:[2-4x]|\s(?:bionic|x2|pro|razr))?:?(\s4g)?)[\w\s]+build\//i,/mot[\s-]?(\w*)/i,/(XT\d{3,4}) build\//i,/(nexus\s6)/i],[l,[b,"Motorola"],[c,f]],[/android.+\s(mz60\d|xoom[\s2]{0,2})\sbuild\//i],[l,[b,"Motorola"],[c,h]],[/hbbtv\/\d+\.\d+\.\d+\s+\([\w\s]*;\s*(\w[^;]*);([^;]*)/i],[[b,y.trim],[l,y.trim],[c,v]],[/hbbtv.+maple;(\d+)/i],[[l,/^/,"SmartTV"],[b,"Samsung"],[c,v]],[/\(dtv[\);].+(aquos)/i],[l,[b,"Sharp"],[c,v]],[/android.+((sch-i[89]0\d|shw-m380s|gt-p\d{4}|gt-n\d+|sgh-t8[56]9|nexus 10))/i,/((SM-T\w+))/i],[[b,"Samsung"],l,[c,h]],[/smart-tv.+(samsung)/i],[b,[c,v],l],[/((s[cgp]h-\w+|gt-\w+|galaxy\snexus|sm-\w[\w\d]+))/i,/(sam[sung]*)[\s-]*(\w+-?[\w-]*)/i,/sec-((sgh\w+))/i],[[b,"Samsung"],l,[c,f]],[/sie-(\w*)/i],[l,[b,"Siemens"],[c,f]],[/(maemo|nokia).*(n900|lumia\s\d+)/i,/(nokia)[\s_-]?([\w-]*)/i],[[b,"Nokia"],l,[c,f]],[/android[x\d\.\s;]+\s([ab][1-7]\-?[0178a]\d\d?)/i],[l,[b,"Acer"],[c,h]],[/android.+([vl]k\-?\d{3})\s+build/i],[l,[b,"LG"],[c,h]],[/android\s3\.[\s\w;-]{10}(lg?)-([06cv9]{3,4})/i],[[b,"LG"],l,[c,h]],[/(lg) netcast\.tv/i],[b,l,[c,v]],[/(nexus\s[45])/i,/lg[e;\s\/-]+(\w*)/i,/android.+lg(\-?[\d\w]+)\s+build/i],[l,[b,"LG"],[c,f]],[/(lenovo)\s?(s(?:5000|6000)(?:[\w-]+)|tab(?:[\s\w]+))/i],[b,l,[c,h]],[/android.+(ideatab[a-z0-9\-\s]+)/i],[l,[b,"Lenovo"],[c,h]],[/(lenovo)[_\s-]?([\w-]+)/i],[b,l,[c,f]],[/linux;.+((jolla));/i],[b,l,[c,f]],[/((pebble))app\/[\d\.]+\s/i],[b,l,[c,x]],[/android.+;\s(oppo)\s?([\w\s]+)\sbuild/i],[b,l,[c,f]],[/crkey/i],[[l,"Chromecast"],[b,"Google"],[c,v]],[/android.+;\s(glass)\s\d/i],[l,[b,"Google"],[c,x]],[/android.+;\s(pixel c)[\s)]/i],[l,[b,"Google"],[c,h]],[/android.+;\s(pixel( [23])?( xl)?)[\s)]/i],[l,[b,"Google"],[c,f]],[/android.+;\s(\w+)\s+build\/hm\1/i,/android.+(hm[\s\-_]*note?[\s_]*(?:\d\w)?)\s+build/i,/android.+(mi[\s\-_]*(?:a\d|one|one[\s_]plus|note lte)?[\s_]*(?:\d?\w?)[\s_]*(?:plus)?)\s+build/i,/android.+(redmi[\s\-_]*(?:note)?(?:[\s_]*[\w\s]+))\s+build/i],[[l,/_/g," "],[b,"Xiaomi"],[c,f]],[/android.+(mi[\s\-_]*(?:pad)(?:[\s_]*[\w\s]+))\s+build/i],[[l,/_/g," "],[b,"Xiaomi"],[c,h]],[/android.+;\s(m[1-5]\snote)\sbuild/i],[l,[b,"Meizu"],[c,f]],[/(mz)-([\w-]{2,})/i],[[b,"Meizu"],l,[c,f]],[/android.+a000(1)\s+build/i,/android.+oneplus\s(a\d{4})[\s)]/i],[l,[b,"OnePlus"],[c,f]],[/android.+[;\/]\s*(RCT[\d\w]+)\s+build/i],[l,[b,"RCA"],[c,h]],[/android.+[;\/\s]+(Venue[\d\s]{2,7})\s+build/i],[l,[b,"Dell"],[c,h]],[/android.+[;\/]\s*(Q[T|M][\d\w]+)\s+build/i],[l,[b,"Verizon"],[c,h]],[/android.+[;\/]\s+(Barnes[&\s]+Noble\s+|BN[RT])(V?.*)\s+build/i],[[b,"Barnes & Noble"],l,[c,h]],[/android.+[;\/]\s+(TM\d{3}.*\b)\s+build/i],[l,[b,"NuVision"],[c,h]],[/android.+;\s(k88)\sbuild/i],[l,[b,"ZTE"],[c,h]],[/android.+[;\/]\s*(gen\d{3})\s+build.*49h/i],[l,[b,"Swiss"],[c,f]],[/android.+[;\/]\s*(zur\d{3})\s+build/i],[l,[b,"Swiss"],[c,h]],[/android.+[;\/]\s*((Zeki)?TB.*\b)\s+build/i],[l,[b,"Zeki"],[c,h]],[/(android).+[;\/]\s+([YR]\d{2})\s+build/i,/android.+[;\/]\s+(Dragon[\-\s]+Touch\s+|DT)(\w{5})\sbuild/i],[[b,"Dragon Touch"],l,[c,h]],[/android.+[;\/]\s*(NS-?\w{0,9})\sbuild/i],[l,[b,"Insignia"],[c,h]],[/android.+[;\/]\s*((NX|Next)-?\w{0,9})\s+build/i],[l,[b,"NextBook"],[c,h]],[/android.+[;\/]\s*(Xtreme\_)?(V(1[045]|2[015]|30|40|60|7[05]|90))\s+build/i],[[b,"Voice"],l,[c,f]],[/android.+[;\/]\s*(LVTEL\-)?(V1[12])\s+build/i],[[b,"LvTel"],l,[c,f]],[/android.+;\s(PH-1)\s/i],[l,[b,"Essential"],[c,f]],[/android.+[;\/]\s*(V(100MD|700NA|7011|917G).*\b)\s+build/i],[l,[b,"Envizen"],[c,h]],[/android.+[;\/]\s*(Le[\s\-]+Pan)[\s\-]+(\w{1,9})\s+build/i],[b,l,[c,h]],[/android.+[;\/]\s*(Trio[\s\-]*.*)\s+build/i],[l,[b,"MachSpeed"],[c,h]],[/android.+[;\/]\s*(Trinity)[\-\s]*(T\d{3})\s+build/i],[b,l,[c,h]],[/android.+[;\/]\s*TU_(1491)\s+build/i],[l,[b,"Rotor"],[c,h]],[/android.+(KS(.+))\s+build/i],[l,[b,"Amazon"],[c,h]],[/android.+(Gigaset)[\s\-]+(Q\w{1,9})\s+build/i],[b,l,[c,h]],[/\s(tablet|tab)[;\/]/i,/\s(mobile)(?:[;\/]|\ssafari)/i],[[c,y.lowerize],b,l],[/[\s\/\(](smart-?tv)[;\)]/i],[[c,v]],[/(android[\w\.\s\-]{0,9});.+build/i],[l,[b,"Generic"]]],engine:[[/windows.+\sedge\/([\w\.]+)/i],[m,[u,"EdgeHTML"]],[/webkit\/537\.36.+chrome\/(?!27)([\w\.]+)/i],[m,[u,"Blink"]],[/(presto)\/([\w\.]+)/i,/(webkit|trident|netfront|netsurf|amaya|lynx|w3m|goanna)\/([\w\.]+)/i,/(khtml|tasman|links)[\/\s]\(?([\w\.]+)/i,/(icab)[\/\s]([23]\.[\d\.]+)/i],[u,m],[/rv\:([\w\.]{1,9}).+(gecko)/i],[m,u]],os:[[/microsoft\s(windows)\s(vista|xp)/i],[u,m],[/(windows)\snt\s6\.2;\s(arm)/i,/(windows\sphone(?:\sos)*)[\s\/]?([\d\.\s\w]*)/i,/(windows\smobile|windows)[\s\/]?([ntce\d\.\s]+\w)/i],[u,[m,T.str,A.os.windows.version]],[/(win(?=3|9|n)|win\s9x\s)([nt\d\.]+)/i],[[u,"Windows"],[m,T.str,A.os.windows.version]],[/\((bb)(10);/i],[[u,"BlackBerry"],m],[/(blackberry)\w*\/?([\w\.]*)/i,/(tizen|kaios)[\/\s]([\w\.]+)/i,/(android|webos|palm\sos|qnx|bada|rim\stablet\sos|meego|sailfish|contiki)[\/\s-]?([\w\.]*)/i],[u,m],[/(symbian\s?os|symbos|s60(?=;))[\/\s-]?([\w\.]*)/i],[[u,"Symbian"],m],[/\((series40);/i],[u],[/mozilla.+\(mobile;.+gecko.+firefox/i],[[u,"Firefox OS"],m],[/(nintendo|playstation)\s([wids34portablevu]+)/i,/(mint)[\/\s\(]?(\w*)/i,/(mageia|vectorlinux)[;\s]/i,/(joli|[kxln]?ubuntu|debian|suse|opensuse|gentoo|(?=\s)arch|slackware|fedora|mandriva|centos|pclinuxos|redhat|zenwalk|linpus)[\/\s-]?(?!chrom)([\w\.-]*)/i,/(hurd|linux)\s?([\w\.]*)/i,/(gnu)\s?([\w\.]*)/i],[u,m],[/(cros)\s[\w]+\s([\w\.]+\w)/i],[[u,"Chromium OS"],m],[/(sunos)\s?([\w\.\d]*)/i],[[u,"Solaris"],m],[/\s([frentopc-]{0,4}bsd|dragonfly)\s?([\w\.]*)/i],[u,m],[/(haiku)\s(\w+)/i],[u,m],[/cfnetwork\/.+darwin/i,/ip[honead]{2,4}(?:.*os\s([\w]+)\slike\smac|;\sopera)/i],[[m,/_/g,"."],[u,"iOS"]],[/(mac\sos\sx)\s?([\w\s\.]*)/i,/(macintosh|mac(?=_powerpc)\s)/i],[[u,"Mac OS"],[m,/_/g,"."]],[/((?:open)?solaris)[\/\s-]?([\w\.]*)/i,/(aix)\s((\d)(?=\.|\)|\s)[\w\.])*/i,/(plan\s9|minix|beos|os\/2|amigaos|morphos|risc\sos|openvms|fuchsia)/i,/(unix)\s?([\w\.]*)/i],[u,m]]},E=function(e,r){if("object"==typeof e&&(r=e,e=s),!(this instanceof E))return new E(e,r).getResult();var a=e||(i&&i.navigator&&i.navigator.userAgent?i.navigator.userAgent:o),n=r?y.extend(S,r):S;return this.getBrowser=function(){var i={name:s,version:s};return T.rgx.call(i,a,n.browser),i.major=y.major(i.version),i},this.getCPU=function(){var i={architecture:s};return T.rgx.call(i,a,n.cpu),i},this.getDevice=function(){var i={vendor:s,model:s,type:s};return T.rgx.call(i,a,n.device),i},this.getEngine=function(){var i={name:s,version:s};return T.rgx.call(i,a,n.engine),i},this.getOS=function(){var i={name:s,version:s};return T.rgx.call(i,a,n.os),i},this.getResult=function(){return{ua:this.getUA(),browser:this.getBrowser(),engine:this.getEngine(),os:this.getOS(),device:this.getDevice(),cpu:this.getCPU()}},this.getUA=function(){return a},this.setUA=function(i){return a=i,this},this};E.VERSION=e,E.BROWSER={NAME:u,MAJOR:w,VERSION:m},E.CPU={ARCHITECTURE:p},E.DEVICE={MODEL:l,VENDOR:b,TYPE:c,CONSOLE:g,MOBILE:f,SMARTTV:v,TABLET:h,WEARABLE:x,EMBEDDED:k},E.ENGINE={NAME:u,VERSION:m},E.OS={NAME:u,VERSION:m},typeof exports!==n?(typeof module!==n&&module.exports&&(exports=module.exports=E),exports.UAParser=E):"function"==typeof define&&define.amd?define(function(){return E}):i&&(i.UAParser=E);var N=i&&(i.jQuery||i.Zepto);if(N&&!N.ua){var z=new E;N.ua=z.getResult(),N.ua.get=function(){return z.getUA()},N.ua.set=function(i){z.setUA(i);var s=z.getResult();for(var e in s)N.ua[e]=s[e]}}}("object"==typeof window?window:this);

var UA = new UAParser();
var browser = UA.getBrowser();
var cpu = UA.getCPU();
var device = UA.getDevice();
var engine = UA.getEngine();
var os = UA.getOS();
var ua = UA.getUA();

var setDefaults = function setDefaults(p) {
  var d = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'none';
  return p ? p : d;
};
var getNavigatorInstance = function getNavigatorInstance() {
  if (typeof window !== 'undefined') {
    if (window.navigator || navigator) {
      return window.navigator || navigator;
    }
  }

  return false;
};
var isIOS13Check = function isIOS13Check(type) {
  var nav = getNavigatorInstance();
  return nav && nav.platform && (nav.platform.indexOf(type) !== -1 || nav.platform === 'MacIntel' && nav.maxTouchPoints > 1 && !window.MSStream);
};

function _typeof(obj) {
  if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") {
    _typeof = function (obj) {
      return typeof obj;
    };
  } else {
    _typeof = function (obj) {
      return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
    };
  }

  return _typeof(obj);
}

function _classCallCheck(instance, Constructor) {
  if (!(instance instanceof Constructor)) {
    throw new TypeError("Cannot call a class as a function");
  }
}

function _defineProperties(target, props) {
  for (var i = 0; i < props.length; i++) {
    var descriptor = props[i];
    descriptor.enumerable = descriptor.enumerable || false;
    descriptor.configurable = true;
    if ("value" in descriptor) descriptor.writable = true;
    Object.defineProperty(target, descriptor.key, descriptor);
  }
}

function _createClass(Constructor, protoProps, staticProps) {
  if (protoProps) _defineProperties(Constructor.prototype, protoProps);
  if (staticProps) _defineProperties(Constructor, staticProps);
  return Constructor;
}

function _defineProperty(obj, key, value) {
  if (key in obj) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
  } else {
    obj[key] = value;
  }

  return obj;
}

function _extends() {
  _extends = Object.assign || function (target) {
    for (var i = 1; i < arguments.length; i++) {
      var source = arguments[i];

      for (var key in source) {
        if (Object.prototype.hasOwnProperty.call(source, key)) {
          target[key] = source[key];
        }
      }
    }

    return target;
  };

  return _extends.apply(this, arguments);
}

function ownKeys(object, enumerableOnly) {
  var keys = Object.keys(object);

  if (Object.getOwnPropertySymbols) {
    var symbols = Object.getOwnPropertySymbols(object);
    if (enumerableOnly) symbols = symbols.filter(function (sym) {
      return Object.getOwnPropertyDescriptor(object, sym).enumerable;
    });
    keys.push.apply(keys, symbols);
  }

  return keys;
}

function _objectSpread2(target) {
  for (var i = 1; i < arguments.length; i++) {
    var source = arguments[i] != null ? arguments[i] : {};

    if (i % 2) {
      ownKeys(source, true).forEach(function (key) {
        _defineProperty(target, key, source[key]);
      });
    } else if (Object.getOwnPropertyDescriptors) {
      Object.defineProperties(target, Object.getOwnPropertyDescriptors(source));
    } else {
      ownKeys(source).forEach(function (key) {
        Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key));
      });
    }
  }

  return target;
}

function _inherits(subClass, superClass) {
  if (typeof superClass !== "function" && superClass !== null) {
    throw new TypeError("Super expression must either be null or a function");
  }

  subClass.prototype = Object.create(superClass && superClass.prototype, {
    constructor: {
      value: subClass,
      writable: true,
      configurable: true
    }
  });
  if (superClass) _setPrototypeOf(subClass, superClass);
}

function _getPrototypeOf(o) {
  _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) {
    return o.__proto__ || Object.getPrototypeOf(o);
  };
  return _getPrototypeOf(o);
}

function _setPrototypeOf(o, p) {
  _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) {
    o.__proto__ = p;
    return o;
  };

  return _setPrototypeOf(o, p);
}

function _assertThisInitialized(self) {
  if (self === void 0) {
    throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
  }

  return self;
}

function _possibleConstructorReturn(self, call) {
  if (call && (typeof call === "object" || typeof call === "function")) {
    return call;
  }

  return _assertThisInitialized(self);
}

var DEVICE_TYPES = {
  MOBILE: 'mobile',
  TABLET: 'tablet',
  SMART_TV: 'smarttv',
  CONSOLE: 'console',
  WEARABLE: 'wearable',
  BROWSER: undefined
};
var BROWSER_TYPES = {
  CHROME: 'Chrome',
  FIREFOX: "Firefox",
  OPERA: "Opera",
  YANDEX: "Yandex",
  SAFARI: "Safari",
  INTERNET_EXPLORER: "Internet Explorer",
  EDGE: "Edge",
  CHROMIUM: "Chromium",
  IE: 'IE',
  MOBILE_SAFARI: "Mobile Safari",
  EDGE_CHROMIUM: "Edge Chromium"
};
var OS_TYPES = {
  IOS: 'iOS',
  ANDROID: "Android",
  WINDOWS_PHONE: "Windows Phone",
  WINDOWS: 'Windows',
  MAC_OS: 'Mac OS'
};
var initialData = {
  isMobile: false,
  isTablet: false,
  isBrowser: false,
  isSmartTV: false,
  isConsole: false,
  isWearable: false
};
var checkType = function checkType(type) {
  switch (type) {
    case DEVICE_TYPES.MOBILE:
      return {
        isMobile: true
      };

    case DEVICE_TYPES.TABLET:
      return {
        isTablet: true
      };

    case DEVICE_TYPES.SMART_TV:
      return {
        isSmartTV: true
      };

    case DEVICE_TYPES.CONSOLE:
      return {
        isConsole: true
      };

    case DEVICE_TYPES.WEARABLE:
      return {
        isWearable: true
      };

    case DEVICE_TYPES.BROWSER:
      return {
        isBrowser: true
      };

    default:
      return initialData;
  }
};
var broPayload = function broPayload(isBrowser, browser, engine, os, ua) {
  return {
    isBrowser: isBrowser,
    browserMajorVersion: setDefaults(browser.major),
    browserFullVersion: setDefaults(browser.version),
    browserName: setDefaults(browser.name),
    engineName: setDefaults(engine.name),
    engineVersion: setDefaults(engine.version),
    osName: setDefaults(os.name),
    osVersion: setDefaults(os.version),
    userAgent: setDefaults(ua)
  };
};
var mobilePayload = function mobilePayload(type, device, os, ua) {
  return _objectSpread2({}, type, {
    vendor: setDefaults(device.vendor),
    model: setDefaults(device.model),
    os: setDefaults(os.name),
    osVersion: setDefaults(os.version),
    ua: setDefaults(ua)
  });
};
var stvPayload = function stvPayload(isSmartTV, engine, os, ua) {
  return {
    isSmartTV: isSmartTV,
    engineName: setDefaults(engine.name),
    engineVersion: setDefaults(engine.version),
    osName: setDefaults(os.name),
    osVersion: setDefaults(os.version),
    userAgent: setDefaults(ua)
  };
};
var consolePayload = function consolePayload(isConsole, engine, os, ua) {
  return {
    isConsole: isConsole,
    engineName: setDefaults(engine.name),
    engineVersion: setDefaults(engine.version),
    osName: setDefaults(os.name),
    osVersion: setDefaults(os.version),
    userAgent: setDefaults(ua)
  };
};
var wearPayload = function wearPayload(isWearable, engine, os, ua) {
  return {
    isWearable: isWearable,
    engineName: setDefaults(engine.name),
    engineVersion: setDefaults(engine.version),
    osName: setDefaults(os.name),
    osVersion: setDefaults(os.version),
    userAgent: setDefaults(ua)
  };
};

var type = checkType(device.type);

function deviceDetect() {
  var isBrowser = type.isBrowser,
      isMobile = type.isMobile,
      isTablet = type.isTablet,
      isSmartTV = type.isSmartTV,
      isConsole = type.isConsole,
      isWearable = type.isWearable;

  if (isBrowser) {
    return broPayload(isBrowser, browser, engine, os, ua);
  }

  if (isSmartTV) {
    return stvPayload(isSmartTV, engine, os, ua);
  }

  if (isConsole) {
    return consolePayload(isConsole, engine, os, ua);
  }

  if (isMobile) {
    return mobilePayload(type, device, os, ua);
  }

  if (isTablet) {
    return mobilePayload(type, device, os, ua);
  }

  if (isWearable) {
    return wearPayload(isWearable, engine, os, ua);
  }
}

var isMobileType = function isMobileType() {
  return device.type === DEVICE_TYPES.MOBILE;
};

var isTabletType = function isTabletType() {
  return device.type === DEVICE_TYPES.TABLET;
};

var isMobileAndTabletType = function isMobileAndTabletType() {
  switch (device.type) {
    case DEVICE_TYPES.MOBILE:
    case DEVICE_TYPES.TABLET:
      return true;

    default:
      return false;
  }
};

var isEdgeChromiumType = function isEdgeChromiumType() {
  if (os.name === OS_TYPES.WINDOWS && os.version === '10') {
    return typeof ua === 'string' && ua.indexOf('Edg/') !== -1;
  }

  return false;
};

var isSmartTVType = function isSmartTVType() {
  return device.type === DEVICE_TYPES.SMART_TV;
};

var isBrowserType = function isBrowserType() {
  return device.type === DEVICE_TYPES.BROWSER;
};

var isWearableType = function isWearableType() {
  return device.type === DEVICE_TYPES.WEARABLE;
};

var isConsoleType = function isConsoleType() {
  return device.type === DEVICE_TYPES.CONSOLE;
};

var isAndroidType = function isAndroidType() {
  return os.name === OS_TYPES.ANDROID;
};

var isWindowsType = function isWindowsType() {
  return os.name === OS_TYPES.WINDOWS;
};

var isMacOsType = function isMacOsType() {
  return os.name === OS_TYPES.MAC_OS;
};

var isWinPhoneType = function isWinPhoneType() {
  return os.name === OS_TYPES.WINDOWS_PHONE;
};

var isIOSType = function isIOSType() {
  return os.name === OS_TYPES.IOS;
};

var isChromeType = function isChromeType() {
  return browser.name === BROWSER_TYPES.CHROME;
};

var isFirefoxType = function isFirefoxType() {
  return browser.name === BROWSER_TYPES.FIREFOX;
};

var isChromiumType = function isChromiumType() {
  return browser.name === BROWSER_TYPES.CHROMIUM;
};

var isEdgeType = function isEdgeType() {
  return browser.name === BROWSER_TYPES.EDGE;
};

var isYandexType = function isYandexType() {
  return browser.name === BROWSER_TYPES.YANDEX;
};

var isSafariType = function isSafariType() {
  return browser.name === BROWSER_TYPES.SAFARI || browser.name === BROWSER_TYPES.MOBILE_SAFARI;
};

var isMobileSafariType = function isMobileSafariType() {
  return browser.name === BROWSER_TYPES.MOBILE_SAFARI;
};

var isOperaType = function isOperaType() {
  return browser.name === BROWSER_TYPES.OPERA;
};

var isIEType = function isIEType() {
  return browser.name === BROWSER_TYPES.INTERNET_EXPLORER || browser.name === BROWSER_TYPES.IE;
};

var isElectronType = function isElectronType() {
  var nav = getNavigatorInstance();
  var ua = nav && nav.userAgent.toLowerCase();
  return typeof ua === 'string' ? /electron/.test(ua) : false;
};

var getIOS13 = function getIOS13() {
  var nav = getNavigatorInstance();
  return nav && (/iPad|iPhone|iPod/.test(nav.platform) || nav.platform === 'MacIntel' && nav.maxTouchPoints > 1) && !window.MSStream;
};

var getIPad13 = function getIPad13() {
  return isIOS13Check('iPad');
};

var getIphone13 = function getIphone13() {
  return isIOS13Check('iPhone');
};

var getIPod13 = function getIPod13() {
  return isIOS13Check('iPod');
};

var getBrowserFullVersion = function getBrowserFullVersion() {
  return setDefaults(browser.version);
};

var getBrowserVersion = function getBrowserVersion() {
  return setDefaults(browser.major);
};

var getOsVersion = function getOsVersion() {
  return setDefaults(os.version);
};

var getOsName = function getOsName() {
  return setDefaults(os.name);
};

var getBrowserName = function getBrowserName() {
  return setDefaults(browser.name);
};

var getMobileVendor = function getMobileVendor() {
  return setDefaults(device.vendor);
};

var getMobileModel = function getMobileModel() {
  return setDefaults(device.model);
};

var getEngineName = function getEngineName() {
  return setDefaults(engine.name);
};

var getEngineVersion = function getEngineVersion() {
  return setDefaults(engine.version);
};

var getUseragent = function getUseragent() {
  return setDefaults(ua);
};

var getDeviceType = function getDeviceType() {
  return setDefaults(device.type, 'browser');
};

var isSmartTV = isSmartTVType();
var isConsole = isConsoleType();
var isWearable = isWearableType();
var isMobileSafari = isMobileSafariType() || getIPad13();
var isChromium = isChromiumType();
var isMobile = isMobileAndTabletType() || getIPad13();
var isMobileOnly = isMobileType();
var isTablet = isTabletType() || getIPad13();
var isBrowser = isBrowserType();
var isAndroid = isAndroidType();
var isWinPhone = isWinPhoneType();
var isIOS = isIOSType() || getIPad13();
var isChrome = isChromeType();
var isFirefox = isFirefoxType();
var isSafari = isSafariType();
var isOpera = isOperaType();
var isIE = isIEType();
var osVersion = getOsVersion();
var osName = getOsName();
var fullBrowserVersion = getBrowserFullVersion();
var browserVersion = getBrowserVersion();
var browserName = getBrowserName();
var mobileVendor = getMobileVendor();
var mobileModel = getMobileModel();
var engineName = getEngineName();
var engineVersion = getEngineVersion();
var getUA = getUseragent();
var isEdge = isEdgeType() || isEdgeChromiumType();
var isYandex = isYandexType();
var deviceType = getDeviceType();
var isIOS13 = getIOS13();
var isIPad13 = getIPad13();
var isIPhone13 = getIphone13();
var isIPod13 = getIPod13();
var isElectron = isElectronType();
var isEdgeChromium = isEdgeChromiumType();
var isLegacyEdge = isEdgeType();
var isWindows = isWindowsType();
var isMacOs = isMacOsType();

var AndroidView = function AndroidView(_ref) {
  var renderWithFragment = _ref.renderWithFragment,
      children = _ref.children,
      viewClassName = _ref.viewClassName,
      style = _ref.style;
  return isAndroid ? renderWithFragment ? React__default.createElement(React.Fragment, null, children) : React__default.createElement("div", {
    className: viewClassName,
    style: style
  }, children) : null;
};
var BrowserView = function BrowserView(_ref2) {
  var renderWithFragment = _ref2.renderWithFragment,
      children = _ref2.children,
      viewClassName = _ref2.viewClassName,
      style = _ref2.style;
  return isBrowser ? renderWithFragment ? React__default.createElement(React.Fragment, null, children) : React__default.createElement("div", {
    className: viewClassName,
    style: style
  }, children) : null;
};
var IEView = function IEView(_ref3) {
  var renderWithFragment = _ref3.renderWithFragment,
      children = _ref3.children,
      viewClassName = _ref3.viewClassName,
      style = _ref3.style;
  return isIE ? renderWithFragment ? React__default.createElement(React.Fragment, null, children) : React__default.createElement("div", {
    className: viewClassName,
    style: style
  }, children) : null;
};
var IOSView = function IOSView(_ref4) {
  var renderWithFragment = _ref4.renderWithFragment,
      children = _ref4.children,
      viewClassName = _ref4.viewClassName,
      style = _ref4.style;
  return isIOS ? renderWithFragment ? React__default.createElement(React.Fragment, null, children) : React__default.createElement("div", {
    className: viewClassName,
    style: style
  }, children) : null;
};
var MobileView = function MobileView(_ref5) {
  var renderWithFragment = _ref5.renderWithFragment,
      children = _ref5.children,
      viewClassName = _ref5.viewClassName,
      style = _ref5.style;
  return isMobile ? renderWithFragment ? React__default.createElement(React.Fragment, null, children) : React__default.createElement("div", {
    className: viewClassName,
    style: style
  }, children) : null;
};
var TabletView = function TabletView(_ref6) {
  var renderWithFragment = _ref6.renderWithFragment,
      children = _ref6.children,
      viewClassName = _ref6.viewClassName,
      style = _ref6.style;
  return isTablet ? renderWithFragment ? React__default.createElement(React.Fragment, null, children) : React__default.createElement("div", {
    className: viewClassName,
    style: style
  }, children) : null;
};
var WinPhoneView = function WinPhoneView(_ref7) {
  var renderWithFragment = _ref7.renderWithFragment,
      children = _ref7.children,
      viewClassName = _ref7.viewClassName,
      style = _ref7.style;
  return isWinPhone ? renderWithFragment ? React__default.createElement(React.Fragment, null, children) : React__default.createElement("div", {
    className: viewClassName,
    style: style
  }, children) : null;
};
var MobileOnlyView = function MobileOnlyView(_ref8) {
  var renderWithFragment = _ref8.renderWithFragment,
      children = _ref8.children,
      viewClassName = _ref8.viewClassName,
      style = _ref8.style;
  return isMobileOnly ? renderWithFragment ? React__default.createElement(React.Fragment, null, children) : React__default.createElement("div", {
    className: viewClassName,
    style: style
  }, children) : null;
};
var SmartTVView = function SmartTVView(_ref9) {
  var renderWithFragment = _ref9.renderWithFragment,
      children = _ref9.children,
      viewClassName = _ref9.viewClassName,
      style = _ref9.style;
  return isSmartTV ? renderWithFragment ? React__default.createElement(React.Fragment, null, children) : React__default.createElement("div", {
    className: viewClassName,
    style: style
  }, children) : null;
};
var ConsoleView = function ConsoleView(_ref10) {
  var renderWithFragment = _ref10.renderWithFragment,
      children = _ref10.children,
      viewClassName = _ref10.viewClassName,
      style = _ref10.style;
  return isConsole ? renderWithFragment ? React__default.createElement(React.Fragment, null, children) : React__default.createElement("div", {
    className: viewClassName,
    style: style
  }, children) : null;
};
var WearableView = function WearableView(_ref11) {
  var renderWithFragment = _ref11.renderWithFragment,
      children = _ref11.children,
      viewClassName = _ref11.viewClassName,
      style = _ref11.style;
  return isWearable ? renderWithFragment ? React__default.createElement(React.Fragment, null, children) : React__default.createElement("div", {
    className: viewClassName,
    style: style
  }, children) : null;
};
var CustomView = function CustomView(_ref12) {
  var renderWithFragment = _ref12.renderWithFragment,
      children = _ref12.children,
      viewClassName = _ref12.viewClassName,
      style = _ref12.style,
      condition = _ref12.condition;
  return condition ? renderWithFragment ? React__default.createElement(React.Fragment, null, children) : React__default.createElement("div", {
    className: viewClassName,
    style: style
  }, children) : null;
};

function withOrientationChange(WrappedComponent) {
  return (
    /*#__PURE__*/
    function (_React$Component) {
      _inherits(_class, _React$Component);

      function _class(props) {
        var _this;

        _classCallCheck(this, _class);

        _this = _possibleConstructorReturn(this, _getPrototypeOf(_class).call(this, props));
        _this.isEventListenerAdded = false;
        _this.handleOrientationChange = _this.handleOrientationChange.bind(_assertThisInitialized(_this));
        _this.onOrientationChange = _this.onOrientationChange.bind(_assertThisInitialized(_this));
        _this.onPageLoad = _this.onPageLoad.bind(_assertThisInitialized(_this));
        _this.state = {
          isLandscape: false,
          isPortrait: false
        };
        return _this;
      }

      _createClass(_class, [{
        key: "handleOrientationChange",
        value: function handleOrientationChange() {
          if (!this.isEventListenerAdded) {
            this.isEventListenerAdded = true;
          }

          var orientation = window.innerWidth > window.innerHeight ? 90 : 0;
          this.setState({
            isPortrait: orientation === 0,
            isLandscape: orientation === 90
          });
        }
      }, {
        key: "onOrientationChange",
        value: function onOrientationChange() {
          this.handleOrientationChange();
        }
      }, {
        key: "onPageLoad",
        value: function onPageLoad() {
          this.handleOrientationChange();
        }
      }, {
        key: "componentDidMount",
        value: function componentDidMount() {
          if ((typeof window === "undefined" ? "undefined" : _typeof(window)) !== undefined && isMobile) {
            if (!this.isEventListenerAdded) {
              this.handleOrientationChange();
              window.addEventListener("load", this.onPageLoad, false);
            } else {
              window.removeEventListener("load", this.onPageLoad, false);
            }

            window.addEventListener("resize", this.onOrientationChange, false);
          }
        }
      }, {
        key: "componentWillUnmount",
        value: function componentWillUnmount() {
          window.removeEventListener("resize", this.onOrientationChange, false);
        }
      }, {
        key: "render",
        value: function render() {
          return React__default.createElement(WrappedComponent, _extends({}, this.props, {
            isLandscape: this.state.isLandscape,
            isPortrait: this.state.isPortrait
          }));
        }
      }]);

      return _class;
    }(React__default.Component)
  );
}

ReactDOM.render(<App />, document.getElementById('root'));

document.getElementById('IEMessage').style.display = 'none';

</script>
<h2>Upcoming Hearings</h2>
<h3>October 26, 2020 - April 2021:</h3>
<p>The main hearings, in which Commission Counsel plan to address specific issues*, include:</p>
<ul>
  <li>Gaming, casinos, horseracing</li>
  <li>Real estate</li>
  <li>Professional services, including accounting and legal</li>
  <li>Corporate sector</li>
  <li>Financial institutions and money services</li>
  <li>Luxury goods</li>
  <li>Cryptocurrency</li>
  <li>Cash-based businesses</li>
  <li>Trade-based money laundering</li>
  <li>Other sectors</li>
  <li>Asset recovery</li>
  <li>Enforcement and regulation</li>
  <li>Government response</li>
  <li>Other jurisdictions’ approaches</li>
</ul>
<p>* These topics are not necessarily listed in sequence, and this hearing plan is subject to variation. Information about the dates on which specific topics will be addressed in the hearings will be posted on our website at: <a href="http://www.cullencommission.ca">www.cullencommission.ca</a>.</p>
<p>The location of these hearings will be announced in due course.</p>
<p>For an alphabetical list of witnesses from completed hearings, please go to our <a href="https://cullencommission.ca/witnesses/">Witnesses page</a>.</p>
<p>You can find the webcast archives of completed hearings at our <a href="https://cullencommission.ca/webcast-archive/">Webcast Archive page</a>.</p>
<p>You can find the transcripts of completed hearings at our <a href="https://cullencommission.ca/transcripts/">Transcripts page</a>.</p>
<p>You can find the exhibits from completed hearings at our <a href="https://cullencommission.ca/exhibits/">Exhibits page</a>.</p>
<h2>Completed Hearings</h2>
<h3>February 24 - 26:</h3>
<p>These hearings focused on participants’ opening statements and provided an opportunity for participants (groups, organizations and individuals granted formal standing) to address the Commissioner and to set out the issues and matters that participants would like to see the Inquiry address.</p>
<p><strong>Order of participants:</strong></p>
<ol>
  <li>Ministry of Attorney General - Gaming Policy Enforcement Branch and Ministry of Attorney General - Ministry of Finance - <a href="/files/OpeningStatement-GPEBAndTheMinistryOfFinance.pdf" target="_blank">Opening Statement</a> </li>
  <li>Government of Canada - <a href="/files/OpeningStatement-GovernmentOfCanada.pdf" target="_blank">Opening Statement</a></li>
  <li>Law Society of BC - <a href="/files/OpeningStatement-LawSocietyOfBC.pdf" target="_blank">Opening Statement</a></li>
  <li>British Columbia Government & Service Employees' Union - <a href="/files/OpeningStatements-BCGEU.pdf" target="_blank">Opening Statement</a></li>
  <li>British Columbia Lottery Corporation - <a href="/files/OpeningStatement-BCLC.pdf" target="_blank">Opening Statement</a></li>
  <li>Great Canadian Gaming Corporation - <a href="/files/OpeningStatement-GCGC.pdf" target="_blank">Opening Statement</a></li>
  <li>James Lightbody - <a href="/files/OpeningStatement-JimLightbody.pdf" target="_blank">Opening Statement</a></li>
  <li>Robert Kroeker - <a href="/files/OpeningStatement-Kroeker.pdf" target="_blank">Opening Statement</a></li>
  <li>Gateway Casinos & Entertainment Ltd. - <a href="/files/OpeningStatement-GatewayCasinosEntertainment.pdf" target="_blank">Opening Statement</a></li>
  <li>Canadian Gaming Association - <a href="/files/OpeningStatement-CGA.pdf" target="_blank">Opening Statement</a></li>
  <li>Society of Notaries Public of BC - <a href="/files/OpeningStatement-SNPBC.pdf" target="_blank">Opening Statement</a></li>
  <li>BMW - <a href="/files/OpeningStatement-BMW.pdf" target="_blank">Opening Statement</a></li>
  <li>Coalition: Transparency International Canada (TI Canada), Canadians For Tax Fairness (C4TF), Publish What you Pay Canada (PWYP), - <a href="/files/OpeningStatement-Coalition.pdf" target="_blank">Opening Statement</a></li>
  <li>BC Real Estate Association - <a href="/files/OpeningStatement-BCREA.pdf" target="_blank">Opening Statement</a></li>
  <li>British Columbia Civil Liberties Association - <a href="/files/OpeningStatement-BCCLA.pdf" target="_blank">Opening Statement</a></li>
  <li>Canadian Bar Association, BC Branch and Criminal Defence Advocacy Society - <a href="/files/OpeningStatement-CBA-CDAS.pdf" target="_blank">Opening Statement</a></li>
</ol>
<h3>May 25 - June 17:</h3>
<p>These hearings dealt with an overview of the money laundering topic and regulatory models. Adjustments to the hearing plan were made in response to the global pandemic and its impact on some participants and witnesses.</p>
<p>These hearings were held via videoconferencing.</p>
<p>Video archives of these hearings can be <a href="http://www.cullencommission.ca/webcast-archive/">found here</a>.</p>
<p>You can see the witness list and their testimony date <a href="http://www.cullencommission.ca/media/?open=18">here</a>.</p>
<?php
include($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php');
?>