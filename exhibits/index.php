<?php
$title = 'Exhibits';
$subNavOpen = '#NavbarHearings';
$navExhibits = true;
include($_SERVER['DOCUMENT_ROOT'] . '/includes/head.php');
include($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include($_SERVER['DOCUMENT_ROOT'] . '/includes/navbar.php');
?>
<h1>Exhibits</h1>
<noscript>You need to enable JavaScript to run this app.</noscript>
<div id="root"></div>
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
        return (
            <div id="App">
                {state.exhibits}
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
                state.exhibits = [];
                let rawExhibits = [];
                for (const hearing of res.data.hearings) {
                    if (hearing[1].exhibits.length > 0) {
                        for (const exhibitFromHearing of hearing[1].exhibits) {
                            rawExhibits.push(exhibitFromHearing);
                        }
                    }
                }
                rawExhibits.sort(sortExhibitArray);
                if (rawExhibits.length > 0) {
                    for (const exhibit of rawExhibits) {
                        state.exhibits.push(<Exhibit exhibitNumber={exhibit[0]} exhibitTitle={exhibit[1]} exhibitName={exhibit[2]}></Exhibit>);
                    }
                } else {
                    state.exhibits.push(<p>Exhibits will be posted here once they are uploaded.</p>);
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

class Exhibit extends React.Component {
    render() {
        let devUrl = (state.isDev) ? '/dataDev' : '/data';
        return (
            <div className="ExhibitElement">
                <p>#{this.props.exhibitNumber}</p>
                <p><a href={devUrl + '/exhibits/' + this.props.exhibitName} target="_blank">{this.props.exhibitTitle}</a></p>
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
exhibits: null,
};

function sortExhibitArray(a, b) {
return b[0].localeCompare(a[0], 'en', {numeric: true, sensitivity: 'base'});
}

ReactDOM.render(<App />, document.getElementById('root'));

</script>
<?php
include($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php');
?>