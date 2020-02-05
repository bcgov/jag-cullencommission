<?php
$title = 'FAQ';
include($_SERVER['DOCUMENT_ROOT'] . '/includes/head.php');
include($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php');
include($_SERVER['DOCUMENT_ROOT'] . '/includes/navbar.php');
?>
<h1>FAQs</h1>
<p><strong>The FAQs will be updated as needed over the coming months. Please check back often for additional information.</strong></p>
<div class="ExpandableSectionAccordion">
    <div class="ExpandableSectionTitleContainer" id="ExpandableSection07">
        <p class="ExpandableSectionTitle">When are the public hearings?</p>
    </div>
    <div class="ExpandableSection" id="ExpandableSectionContent07">
        <p>Please look at our <a href="/schedule/">Hearings Schedule</a> for dates, times, and locations of all our public hearings.</p>
    </div>
    <div class="ExpandableSectionTitleContainer" id="ExpandableSection01">
        <p class="ExpandableSectionTitle">What is a participant?</p>
    </div>
    <div class="ExpandableSection" id="ExpandableSectionContent01">
        <p>For the Commission of Inquiry into Money Laundering in British Columbia, a “participant” is a special term with a meaning under the provincial <a href="/pub-inq-act/">Public Inquiry Act</a> that goes beyond the everyday meaning of the word. The legislation uses the word “participant” to describe someone who would usually be considered a “party” in litigation — that is, someone who is granted standing and who can have a lawyer involved in the trial or hearing. The Act describes a “participant” as someone whose interests may be affected by the findings of the Commission, who may further the conduct of the Inquiry, and/or a person who would contribute to the fairness of the Inquiry.</p>
        <p>This means that when a person, organization or group is granted participant status, they can be involved in the Inquiry in a number of ways. While different participants will be involved in different ways, in general terms, participants will have access to documents and materials that are assembled by the Commission, they will be able to ask questions of witnesses, they can propose certain topics and witnesses for the hearings, and they can make opening and closing submissions. These are just a few examples of how participants are involved in an inquiry.</p>
    </div>
    <div class="ExpandableSectionTitleContainer" id="ExpandableSection02">
        <p class="ExpandableSectionTitle">Can someone without participant status provide information to the Commission?</p>
    </div>
    <div class="ExpandableSection" id="ExpandableSectionContent02">
        <p>Absolutely. Being granted standing as a participant is one way to provide information to the Commission. However, a person or organization need not be a formal “participant” to share information or engage with our work. For instance, a person may be called as a “witness” or asked to speak to Commission Counsel as a subject matter expert in order to assist the Commission in understanding detailed or technical issues. The Commission has stated that it welcomes information and input from people, and this can be done by emailing: <a href="mailto:contact@cullencommission.ca">contact@cullencommission.ca</a>.</p>
    </div>
    <div class="ExpandableSectionTitleContainer" id="ExpandableSection03">
        <p class="ExpandableSectionTitle">What is the difference between a participant and a witness?</p>
    </div>
    <div class="ExpandableSection" id="ExpandableSectionContent03">
        <p>A &ldquo;participant&rdquo; is someone who has been granted standing by Commissioner Cullen, as described in the question above, <em>What is a participant?</em></p>
        <p>A &ldquo;witness&rdquo; is someone who is called to testify during the public hearing component of the process. Much like a court case, a witness would be questioned while under oath or solemn affirmation. For the Commission of Inquiry into Money Laundering in British Columbia, being called as a witness means that Commission Counsel feels that a person has knowledge about a specific matter related to the Inquiry. Witnesses are questioned by Commission Counsel as well as by counsel for participants.</p>
        <p>The terms &ldquo;participant&rdquo; and &ldquo;witness&rdquo; are different, but they may overlap. A person may be a participant and may also testify, making them a witness as well. Many witnesses will testify without being participants. (Some witnesses may have counsel without becoming formal participants.)</p>
        <p>The term &ldquo;witness&rdquo; refers to anyone who steps into the witness box and gives evidence under oath before the Commissioner in the public hearings.</p>
    </div>
    <div class="ExpandableSectionTitleContainer" id="ExpandableSection04">
        <p class="ExpandableSectionTitle">Does being called as a witness mean that you are the subject of some sort of criminal investigation or that the Commission thinks you did something wrong?</p>
    </div>
    <div class="ExpandableSection" id="ExpandableSectionContent04">
        <p>No. Within the context of this Commission, being called as a witness means that Commission Counsel believes the person has knowledge about a specific matter relevant to the Inquiry.</p>
        <p>The Commission of Inquiry into Money Laundering in British Columbia has very specific <a href="/tor/">Terms of Reference</a>. Our role is not to undertake a criminal investigation. If, during the course of delivering on our mandate, we discover criminal acts, we would refer those to the police or Crown Counsel.</p>
    </div>
    <div class="ExpandableSectionTitleContainer" id="ExpandableSection05">
        <p class="ExpandableSectionTitle">How would an average person with information that would be of interest to the Commission contact you?</p>
    </div>
    <div class="ExpandableSection" id="ExpandableSectionContent05">
        <p>You can email us at <a href="mailto:contact@cullencommission.ca">contact@cullencommission.ca</a>. We encourage those who feel that they have information that falls within the mandate of this Commission to contact us.</p>
    </div>
    <div class="ExpandableSectionTitleContainer" id="ExpandableSection06">
        <p class="ExpandableSectionTitle">What happens when someone contacts you with information, is their name kept confidential?</p>
    </div>
    <div class="ExpandableSection" id="ExpandableSectionContent06">
        <p>A person’s name and other personal information will only be released publicly following consultation with the submitter.</p>
    </div>
    <div class="ExpandableSectionTitleContainer" id="ExpandableSection08">
        <p class="ExpandableSectionTitle">Who will be called as witnesses?</p>
    </div>
    <div class="ExpandableSection" id="ExpandableSectionContent08">
        <p>This is currently being determined.</p>
    </div>
    <div class="ExpandableSectionTitleContainer" id="ExpandableSection09">
        <p class="ExpandableSectionTitle">When will you announce who will be called as witnesses?</p>
    </div>
    <div class="ExpandableSection" id="ExpandableSectionContent09">
        <p>We will post the list of anticipated witnesses on the website when determined, and before the expected date of testimony.</p>
    </div>
    <div class="ExpandableSectionTitleContainer" id="ExpandableSection10">
        <p class="ExpandableSectionTitle">I can’t come to Vancouver, but want to see the hearings – how can I do that?</p>
    </div>
    <div class="ExpandableSection" id="ExpandableSectionContent10">
        <p>The hearings will be webcast on this website. We will also post transcripts of hearings and the exhibits filed within a few days of the hearing.</p>
    </div>
</div>
<script>
    $(document).ready(function() {
        let time = 250;
        $('#ExpandableSection01').click(function() {
            $('#ExpandableSectionContent01').slideToggle(time);
        });
        $('#ExpandableSection02').click(function() {
            $('#ExpandableSectionContent02').slideToggle(time);
        });
        $('#ExpandableSection03').click(function() {
            $('#ExpandableSectionContent03').slideToggle(time);
        });
        $('#ExpandableSection04').click(function() {
            $('#ExpandableSectionContent04').slideToggle(time);
        });
        $('#ExpandableSection05').click(function() {
            $('#ExpandableSectionContent05').slideToggle(time);
        });
        $('#ExpandableSection06').click(function() {
            $('#ExpandableSectionContent06').slideToggle(time);
        });
        $('#ExpandableSection07').click(function() {
            $('#ExpandableSectionContent07').slideToggle(time);
        });
        $('#ExpandableSection08').click(function() {
            $('#ExpandableSectionContent08').slideToggle(time);
        });
        $('#ExpandableSection09').click(function() {
            $('#ExpandableSectionContent09').slideToggle(time);
        });
        $('#ExpandableSection10').click(function() {
            $('#ExpandableSectionContent10').slideToggle(time);
        });
    });
</script>


<?php
include($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php');
?>