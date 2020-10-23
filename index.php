<?php
$navHome = true;
include($_SERVER['DOCUMENT_ROOT'] . '/includes/head.php');
include($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include($_SERVER['DOCUMENT_ROOT'] . '/includes/navbar.php');
?>
<div class="Aside2Col">
    <div class="Aside">
        <p class="AsideTitle">Welcome</p>
        <p>Welcome to the website of the Commission of Inquiry into Money Laundering in British Columbia. We invite you to read&nbsp;<a href="/introductory-statement/"><strong>Commissioner Cullen&rsquo;s Introductory Statement</strong></a>.</p>
    </div>
    <div class="MiniCalendarContainer" id="MiniCalendarContainerId" style="display: none">
        <noscript>You need to enable JavaScript to run this app.</noscript>
        <p style="font-size: 0.85rem; text-align: center">Please click on the date to be taken to that hearing information.</p>
        <div id="root"></div>
    </div>
    <div class="LatestEvents">
        <p class="LatestEventsTitle">Latest Information</p>
        <div class="LatestEventsContainer">
            <div class="LatestEvent">
                <p class="LatestEventDesc">October 22nd, 2020<br /><strong>News Release</strong><br /><a href="/media/?open=21" style="hyphens: none;">Witness List and Hearings Schedule Announced for Week of October 26, 2020</a></p>
            </div>
            <div class="LatestEvent">
                <p class="LatestEventDesc">October 16th, 2020<br /><strong>Ruling</strong><br /><a href="/rulings/">Application for Standing – Ruling #11</a></p>
            </div>
            <div class="LatestEvent">
                <p class="LatestEventDesc">September 29th, 2020<br /><strong>Ruling</strong><br /><a href="/rulings/">Application for Standing – Ruling #10</a></p>
            </div>
        </div>
    </div>
</div>
<br class="ClearFloats" />
<p>The purpose of this website is to provide regular, timely and relevant information to the people of British Columbia about the efforts being undertaken by the Commission.</p>
<p>There is much work going on behind the scenes at the Commission, including:</p>
<ul>
    <li>Extensive research and investigation</li>
    <li>Reviewing and analyzing the four existing reports</li>
    <li>Identifying and obtaining relevant documents, records and correspondence</li>
    <li>Planning and organizing for the fall/winter hearing block: October 13, 2020 - April 2021</li>
</ul>
<p>We will continue to regularly update this website.</p>
<p>We invite you to follow the Cullen Commission on Twitter (<a href="https://twitter.com/culleninquirybc" target="_blank">@culleninquirybc</a>).</p>
<p>If you have questions for the Commission, please e-mail us at:&nbsp;<a href=" mailto:info@cullencommission.ca"><strong>info@cullencommission.ca</strong></a>.</p>
<script src="/js/axios.min.js"></script>
<script src="/js/react.production.min.js"></script>
<script src="/js/react-dom.production.min.js"></script>
<script src="/js/babel.js"></script>
<script src="/js/date-format/date.format.js"></script>
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
            let thisMonth = new Date(new Date().getFullYear(), new Date().getMonth(), 1);
            let hearingsThisMonth = [];
            for (const hearingMonth of state.hearings.entries()) {
                let month = new Date(hearingMonth[0]);
                if (thisMonth.getFullYear() === month.getFullYear() && thisMonth.getMonth() === month.getMonth()) {
                    hearingsThisMonth.push(month[1]);
                }
            }
            if (hearingsThisMonth.length > 0) {
                let calendar = <Month date={thisMonth}></Month>;
                let isDevHeader = '';
                if (state.isDev) {
                    isDevHeader = <h2 style={{ borderRadius: '5px', fontWeight: '800', fontSize: '4.7rem', textAlign: 'center', textTransform: 'uppercase', color: 'white', backgroundColor: '#6200ffc4', padding: '10px', position: 'absolute', top: '150px', left: '50%', textShadow: '0px 0px 20px black', transform: 'rotate(10deg) translate(-35%, 0%)', width: '850px' }}>TEST VERSION</h2>
                }
                document.getElementById('MiniCalendarContainerId').style.display = 'block';
                cl('HEARINGS SCHEDULED THIS MONTH', INFO);
                return (
                    <div id="App">
                        {isDevHeader}
                        <h3 style={{textAlign: 'center', marginTop: '10px'}}>Current Hearings</h3>
                        <div className="HearingsMiniCalendarApp">
                            {calendar}
                        </div>
                    </div>
                );
            } else {
                document.getElementById('MiniCalendarContainerId').style.display = 'none';
                cl('NO HEARINGS THIS MONTH', INFO);
                return (
                    <div id="App">
                    </div>
                );
            }
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
                    state.hearings = new Map();
                } else {
                    let tmpHearings = new Map(res.data.hearings);
                    state.hearings = new Map();
                    for (const hearing of tmpHearings.entries()) {
                        let preppedHearing = hearing[1];
                        preppedHearing.themes = new Map(preppedHearing.themes);
                        state.hearings.set(hearing[0], preppedHearing);
                    }
                }
                state.isInit = true;
                state.isDev = isDev;
                cl('EDITOR INITIALIZED', SUCCESS);
                this.forceUpdate();
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
      daysOfMonth.push(<Day key={ currentDate.getTime() } date={ currentDate }></Day>);
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
    handleDayClick() {
        if (state.hearings.has(this.props.date.getTime())) {
            if (state.isDev) {
                window.location.href = '/schedule/?dev=t&h=' + state.hearings.get(this.props.date.getTime()).timeStamp;
            } else {
                window.location.href = '/schedule/?h=' + state.hearings.get(this.props.date.getTime()).timeStamp;
            }
        }
    }

    render() {
        if (this.props.clearDay) {
            return (
                <div className="ClearDay"></div>
            );
        } else {
            let cssClasses = 'Day';
            let today = new Date();
            if (state.hearings.has(this.props.date.getTime())) {
                cssClasses += ' EvidentiaryHearing';
            }
            return (
                <div className={ cssClasses } onClick={ this.handleDayClick.bind(this) }>{ this.props.date.getDate() }</div>
            );
        }
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
    hearings: null,
};

ReactDOM.render(<App />, document.getElementById('root'));

</script>
<?php
include($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php');
?>