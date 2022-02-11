<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if(defined('G5_THEME_PATH')) {
    require_once(G5_THEME_SHOP_PATH.'/shop.tail.php');
    return;
}

$admin = get_admin("super");

// 사용자 화면 우측과 하단을 담당하는 페이지입니다.
// 우측, 하단 화면을 꾸미려면 이 파일을 수정합니다.
?>
<section class="h300" style="background-color:#FFF;">
		<div class="w1000">
			<div id="customer_wrap">
				<span id="info" class="fl m1">
					<section>
						<h1>Customer Service</h1>
						<a href="tel:1677-5544"><h2>1677-5544</h2></a>
						<p>Weekday 09:00~18:00</p>
						<p>Weekend 09:00~18:00</p>
						<p>Lunchbreak 09:00~18:00</p>
					</section>
					<a class="inq" href="<?php if(get_session($lang)==1) echo G5_BBS_URL."/board.php?bo_table=free_cn";
          else echo G5_BBS_URL."/board.php?bo_table=free";?>">Online Inquiry <span class="fr">></span></a>
				</span>
				<section id="posts" class="m1">
					<div class="fl m1 posts_qa">
						<? if(get_session($lang)==1) echo latest ('notice', 'qa_cn', 5);
               else echo latest ('notice', 'qa', 5);?>
					</div>
					<div class="fl m1 posts_free">
            <? if(get_session($lang)==1) echo latest ('notice', 'free_cn', 5);
               else echo latest ('notice', 'free', 5);?>
					</div>
				</section>
			</div>
		</div>
	</section>

<footer>
		<article class="w1000">
			<div style="font-size:1.2em;">
				<img src="/img/logo.png" alt="logo" id="logo" class="fl m0">
				<span class="fl pad10" style="margin-right:15px;">
					<h3>Contact us</h3>
					<p>Company : DOJC KOREA / CEO : Choi Yun Hee<br>Address : 1403.Nonhyeon Building, 183, Bomun-ro, Seongbuk-gu, Seoul
            <br>Business registration : 209-16-70900<br><br><small>Copyrights ⓒ 2020 All Rights Reserved by MYSTARTOUR</small></p>
				</span>
				<span class="fl pad10">
          <h3>Phone number</h3>
					<p>+82-2-953-8370&nbsp;&nbsp;|&nbsp;&nbsp;+82-10-3172-8688</p>
					<h3>E-mail</h3>
					<p>mystartour2020@gmail.com</p>
					<h3 class="trigger" style="cursor:pointer;">Privacy Policy</h3>
					<h3 class="trigger2" style="cursor:pointer;">Terms & Conditions</h3>
				</span>
			</div>
      <div id="overlay_t"></div>
      <div id="popup_layer" class="pop_layer" style="border:3px solid #EC8AAB; padding:15px 25px;">
        <h2>Privacy Policy <span class="p-close">X</span></h2>
        <div class="pop_con">
          DOJCKOREA Corporation('we', 'us', 'our') are committed to protecting and respecting your personal data privacy and complying with data protection principles and provisions under applicable laws.

We may collect, process, use and disclose your information when you use this website www.MYSTARTOURkorea.com and/or the MYSTARTOUR App (together, 'MYSTARTOUR Platform') and the services offered by MYSTARTOUR or the third party operators (the'Operators') through MYSTARTOUR Platform (the 'Services') as described in this Privacy Policy. 'You' and 'your' when used in this Privacy Policy includes any person who accesses MYSTARTOUR Platform or use the Services.

This Privacy Policy sets out the basis and terms upon which MYSTARTOUR collects, processes, uses and/or discloses your information that is obtained from you when you access MYSTARTOUR Platform and/or use the Services. Such information may include personal information relating to or linked to a specific individual such as name, residential address, telephone number, email address, travel document information or any such information we have requested and you have provided through MYSTARTOUR Platform ('Personal Information').

Please read this Privacy Policy carefully. By visiting MYSTARTOUR Platform, you are consenting to the collection, processing, usage and disclosure of your Personal Information as set out in this Privacy Policy.

Scope of Terms

• MYSTARTOUR reserves the right to update, amend or modify the terms of this Privacy Policy or any part of it without prior notice, and your continued access of MYSTARTOUR Platform or use of the Services signifies your acceptance of the updated, amended or modified Privacy Policy, unless if the changes reduce your rights in which case we will ask for your consent. If you do not agree to all the terms and conditions in this Privacy Policy and/or any subsequent updates, amendments or modifications thereto, you must stop accessing or otherwise using MYSTARTOUR Platform and the Services.
• Accordingly, please visit this page if you wish to access and view the current version of this Privacy Policy.

Collection of Information

We may collect Personal Information about you that you provide to us while using MYSTARTOUR Platform and information about how you use MYSTARTOUR Platform including when you open your user account ('User Account'), visit MYSTARTOUR Platform or make reservations for any intended Services or using the Services. Providing your Personal Information to MYSTARTOUR is always on a voluntary basis. However, we might not be able to provide you with certain services if you choose not to give us your Personal Information. For example, we cannot open your user account or make reservations for you if we do not collect your name and contact details.

1) Opening Your User Account
When you open with us a User Account or amend any information of your User Account, we may collect your Personal Information, such as your name, email address, username, password and telephone number.

2) Visit MYSTARTOUR Platform, Making Reservations for the Services or Using the Services:
(a) When you visit MYSTARTOUR Platform (even you have not registered an User Account or logged in), make reservations for any intended Services or use the Services, we may collect and process certain information (which may contain your Personal Information or may contain non-personally identifiable information but nevertheless linked to your Personal Information) including but not limited to those set out below: Copies of correspondence (whether by e-mail, instant or personal messaging or otherwise) between you and us, and between you and the Operators;
(b) Details of your usage of MYSTARTOUR Platform (including traffic data, location data and length of user sessions);
(c) Feedback on and responses to surveys conducted by MYSTARTOUR relating to the Services and newsletters which may be published, circulated or distributed by MYSTARTOUR;
(d) Information automatically collected and stored in our server or the server of our third party services provider by using or accessing to MYSTARTOUR Platform (including the log-in name and password for your User Account, your computers Internet Protocol (IP) address, browser type, browser information, device information (including unique device identifier), pages visited, previous or subsequent sites visited).

3) When you use your mobile devices to visit MYSTARTOUR Platform, we may collect information about you and your mobile device as stated above. This can include location information if you have consented and configured your mobile device to send us such information or upload photos with location information to MYSTARTOUR Platform. Such location information will be used in the ways and for the purposes as stated in this Privacy Policy. For example, we may use your location to suggest nearby Services during your travel or provide personalised content. You can change your mobile device’s privacy settings at any time to deactivate the function of sharing location information. Please note some features of MYSTARTOUR Platform may be affected if you turn off such location sharing function. Should you have any enquiries about your mobile devices’ privacy settings, we recommend you contacting your mobile services provider or the manufacturer of your device.

If you make reservations for other individuals through MYSTARTOUR Platform, we may request personal information about such individual. You must obtain all requisite consent of such individuals and ensure they are aware of, understand and accept this Privacy Policy prior to providing their personal data to MYSTARTOUR.

Storage of Information

The Personal Information and other data we collect from you may be transferred to, processed, and stored in our servers or the servers of our third party services providers.

Your Personal Information will be stored as long as is necessary to fulfil any of the purposes described in this Privacy Policy, or to comply with any (i) contractual requirement that are necessary for the provision of the Services, and (ii) legal, tax or accounting requirement.
When it is no longer necessary for us to process your Personal Information, we will either delete or anonymise the data or, if this is not possible (for example, because your personal information has been stored in backup archives), then we will securely store your personal information.

We will endeavor to anonymise or aggregate your data if we intend to use it for analytical purposes or trend analysis.

MYSTARTOUR will use reasonable endeavours to maintain appropriate physical, electronic and organisational procedures to ensure that your Personal Information and other data is treated securely and in accordance with this Privacy Policy, and to protect such data against unauthorized access or unauthorized alteration, disclosure or destruction of data.

Once we have received your information, we will use strict procedures and security features to try to prevent unauthorized access. MYSTARTOUR does not give any representation, warranty or undertaking that the Personal Information you provide to us will be secure at all times, and to the extent MYSTARTOUR has fulfilled its obligations under no circumstances shall MYSTARTOUR be responsible for any losses, damages, costs and expenses which you may suffer or incur arising from unauthorised access to or use of your Personal Information.

All payment transactions carried out by us or our chosen third-party provider of payment processing services will be encrypted using online encryption technology. You are responsible for keeping your chosen password confidential and not to share your password with any third party.

Usage of Information

We process the Personal Information collected in as far as necessary for performance of the contract with and providing services to you. Besides, we process the other Personal Information collected on the basis of our legitimate interests, which are the further improvement of the services and for direct marketing purposes.

For example, MYSTARTOUR will use Personal Information and other data collected through MYSTARTOUR Platform or when making purchases for the Services to create your User Account, to provide you with the Services, to continually improve MYSTARTOUR Platform and the Services, and to contact you in relation to the Services. This includes using your Personal Information or such other data to achieve faster purchase requests, better customer support and to provide you with timely notice of new Services and special offers.

From time to time, we may also make use of your Personal Information to contact you for feedback on your use of MYSTARTOUR Platform, to assist us in improving MYSTARTOUR Platform, or to offer special savings or promotions to you, where you have indicated your consent to receiving such communications. If you would prefer not to receive notices of special savings or promotions, you may simply opt-out from receiving them by replying to us through the hyperlink provided in these notices.

Disclosure of Information

We may from time to time share and disclose your Personal Information and other data to third parties, some of whom may be located outside your home country. The circumstances under which such sharing and disclosure will take place may include without limitation, the

following:

1) To successfully complete your reservations or otherwise implement our Terms of Use. We may share your information with Operators or third parties who deliver or provide goods and services or otherwise act on our behalf.

2) If you are a visitor, to the relevant Operator in connection with a Services which you have made reservations for or intend to make reservations for.

3) If you are an Operator, to any visitor in connection with the Services you are offering.

4) To our third party service providers (including Google Analytics), which we engage amongst others for the performance of certain services on our behalf, such as web hosting services, data analysis, marketing, market research, and to otherwise provide you with customer service.

5) If and to the extent required by any applicable law, order of court or requests by any governmental authority to make such disclosure.

6) Within the MYSTARTOUR group of companies. In case of a corporate transaction, in connection with the sale, merger, acquisition, or other corporate reorganization or restructuring of our corporation, your Personal Information may be disclosed, shared or transferred to the new controlling entity or its authorised third party for carrying on our business.

7) To our advisors, agencies or other parties concerned in order to protect the rights and property of MYSTARTOUR.

8) In any other case, to any third parties with your prior written consent (and in which case we will make it possible for you to withdraw your consent as easily as it was to provide consent).
We may also share aggregate or anonymous information with relevant third parties, including our advertisers. Such information does not contain any Personal Information and will not identify you personally. However, in some occasions, these third parties may possess information about you or obtain your information from other sources. When they combine such information with our aggregate information, they may be able to identify you personally.

Your Personal Information may be transferred outside of your home country for the abovementioned purposes. If such transfer takes place to a country that does not provide an adequate level of protection, MYSTARTOUR will use reasonable endeavours to ensure that appropriate safeguards are in place.

There may be links present on MYSTARTOUR Platform which could result in you leaving MYSTARTOUR Platform and/or being taken to other third party websites. You should note that any Personal Information that you provide to these third party websites are not subject to this Privacy Policy, and MYSTARTOUR is not liable for any losses, damages, costs or expenses which you may suffer or incur in connection with you providing or making available Personal Information or other data to such third party websites.

Cookies

Cookies are widely used in order to make websites work, or work more efficiently. When you visit our Website, we collect some of your Personal Information transmitted to us by your browser via cookies. This enables you to access MYSTARTOUR Platform and helps us to create better user experience for you. You will find more details about cookies and similar technologies that we use, in our Cookies Policy.

Your rights

You may at all times access, correct or erase your Personal Information through MYSTARTOUR Platform via the user portal, under “My Account”. Alternatively, you may make your data access, correction or erasure request by sending your request by email at mystartour2020@gmail.com.
Where mandatory under applicable legislation, you may also request restriction of processing of your Personal Information or object to processing by sending your request or objection by email at mystartour2020@gmail.com. You may also request a copy of the information that we hold about you by sending your request by email at mystartour2020@gmail.com.
Please contact us via the contact details mentioned below if you have a complaint regarding the processing of your Personal Information.
When handling any of these requests described above, we have the right to check the identity of the requester to ensure that he/she is the person entitled to make the request.

Enquiries

If you have any questions about this Privacy Policy, please contact us by email at mystartour2020@gmail.com
        </div>
      </div>
      <div id="popup_layer2" class="pop_layer" style="border:3px solid #EC8AAB; padding:15px 25px;">
        <h2>Terms & Conditions <span class="p-close">X</span></h2>
        <div class="pop_con">
          1. Your Agreement
1.1 This website (“this Website”) is operated by DOJCKOREA Corporation, a Korea incorporated company. Please read these terms of use (“this Terms of Use”) carefully before using this Website and the services offered by DOJCKOREA Corporation, its affiliated companies (together, “MYSTARTOUR”) or the third-party operators (the “Operator”) through this Website (the “Services”). “You” and “your” when used in this Terms of Use includes (1) any person who accesses the Website and (2) persons for whom you make a purchase of the Services.

2. Change of Terms of Use (MYSTARTOUR's Modifications)
2.1 MYSTARTOUR reserves the right, at its sole discretion, to change or modify any part of this Terms of Use at any time without prior notice. You should visit this page periodically to review the current Terms of Use to which you are bound. If MYSTARTOUR changes or modifies this Terms of Use, MYSTARTOUR will post the changes to or modifications of this Terms of Use on this page and will indicate at the bottom of this page the date on which this Terms of Use was last revised.

2.2 Your continued use of this Website after any such changes or modifications constitutes your acceptance of the revised Terms of Use. If you do not agree to abide by the revised Terms of Use, do not use or access or continue to use or access this Website and/or the Services. It is your responsibility to regularly check this Website to ascertain if there are any changes to this Terms of Use and to review such changes.

2.3 In addition, when using the Services, you shall be subject to any additional terms applicable to such Services that may be posted on the page relating to such Services from time to time and the privacy policy adopted by MYSTARTOUR from time to time (“the Privacy Policy”). All such terms are hereby expressly incorporated by reference in this Terms of Use.

3. Access and Use of the Services
3.1 Ownership of Content
3.1.1 This Website, the domain name (www.MYSTARTOURkorea.com), subdomains, features, contents and application services (including without limitation to any mobile application services) offered periodically by MYSTARTOUR in connection therewith are owned and operated by MYSTARTOUR.

3.2 Provision and Accessibility of Services
3.2.1 Subject to this Terms of Use, MYSTARTOUR may either offer to provide the Services by itself or on behalf of the Operators, as described in further detail on this Website. The Services that have been selected by you on this Website are solely for your own use, and not for the use or benefit of any third party. The term "Services" includes but is not limited to the use of this Website, any Services offered by MYSTARTOUR by itself or on behalf of the Operators on this Website. MYSTARTOUR may change, suspend or discontinue any Services at any time, including the availability of any feature, database or content. MYSTARTOUR may also impose limits or conditions on certain Services or restrict your access to any part or all of the Services without notice or liability.
3.2.2 MYSTARTOUR does not guarantee that the Services will always be available or uninterrupted. MYSTARTOUR will not be liable to you if for any reason the Services are unavailable at any time or for any period. You are responsible for making all arrangements necessary for you to have access to the Services. You are also responsible for ensuring that all persons who access the Services through Internet connection are aware of this Terms of Use and other applicable terms and conditions for the Services, and that they comply with them.
3.2.3 If you link to is Website, MYSTARTOUR may revoke your rights to so link at any time, at MYSTARTOUR’s sole discretion. MYSTARTOUR reserves the right to require prior written consent before linking to this Website.

4. Website and Content
4.1 Use of the Content
4.1.1 All materials displayed or performed on this Website including but not limited to text, data, graphics, articles, photographs, images, illustrations, video, audio and other materials (“Content”) are protected by copyright and/or other intellectual property rights. This Website and the Content are intended solely for your personal and non-commercial use of the Services and may only be used in accordance with this Terms of Use.

4.1.2 If MYSTARTOUR agrees to grant you access to this Website and/or the Content, such access shall be non-exclusive, non-transferable and limited license to access this Website in accordance with this Terms and Use. MYSTARTOUR may, at its absolute discretion and at any time, without prior notice to you, amend or remove or alter the presentation, substance or functionality of any part or all of the Content from this Website.

4.1.3 You shall abide by all copyright notices, trademark rules, information, and restrictions contained in this Website and the Content accessed through this Website, and shall not use, copy, reproduce, modify, translate, publish, broadcast, transmit, distribute, perform, upload, display, license, sell or otherwise exploit for any purposes whatsoever this Website or the Content or third party submissions or other proprietary rights not owned by you without the express prior written consent of the respective owners, or in any way that violates any third party rights.

4.2 MYSTARTOUR’s Liability for the Website and Content
4.2.1 MYSTARTOUR cannot guarantee the identity of any other users with whom you may interact with in the course of using this Website. MYSTARTOUR cannot guarantee the authenticity and accuracy of any content, materials or information which other users or the Operators may provide. All Content accessed by you using this Website is at your own risk and you will be solely responsible for any damage or loss to any party resulting therefrom.

4.2.2 Under no circumstances will MYSTARTOUR be liable in any way for any Content, including but not limited to any errors or omissions in any Content, or any loss or damage of any kind incurred in connection with the use of or exposure to any Content posted, emailed, accessed, transmitted, or otherwise made available via this Website.

5. Intellectual Property Rights
5.1 Intellectual Property
All intellectual property rights subsisting in respect of this Website belong to MYSTARTOUR or have been licensed to MYSTARTOUR for use on this Website. This Website, the Services and the Content are protected by copyright and other intellectual property rights as collective works and/or compilations, pursuant to applicable copyright laws, international conventions, and other intellectual property laws. You undertake that: (a) You shall not modify, publish, transmit, participate in the transfer or sale of, reproduce, create derivative works based on, distribute, perform, display, or in any way exploit, any part of this Website and the Content, software, materials, or the Services in whole or in part; (b) You shall only download or copy the Content (and other items displayed on this Website or related to the Services) for personal and non-commercial use only, provided that you maintain all copyright and other notices contained in such Content; and (c) You shall not store any significant portion of any Content in any form. Copying or storing of any Content other than personal and noncommercial use is expressly prohibited without prior written permission from MYSTARTOUR or from the copyright holder identified in such Contents copyright notice.

6. User Submissions
6.1 Uploading of Information
In the course of accessing this Website or using the Services, you may provide information which may be used by MYSTARTOUR and/or the Operators in connection with the Services and which may be visible to other users of this Website. You understand that by posting information or content on the Website or otherwise providing content, materials or information to MYSTARTOUR and/or the Operators in connection with the Services (“User Submissions”): (a) You hereby grant to MYSTARTOUR and the Operators a non-exclusive, worldwide, royalty free, perpetual, irrevocable, sub-licensable and transferable right to use and fully exploit such User Submissions, including all related intellectual property rights subsisted thereon, in connection with providing the Services and operating this Website and MYSTARTOUR’s business, including but not limited to the promotion and redistribution of part or all of the Services and derivative works thereof in any media formats and through any media channels; (b) You agree and authorize MYSTARTOUR to use your personal data in accordance with the Privacy Policy in effect from time to time; (c) You hereby grant each user of this Website a non-exclusive license to access your User Submissions through this Website, and to use, modify, reproduce, distribute, prepare derivative works of, display and perform such User Submissions as permitted through the functionality of this Website and under this Terms of Use; (d) You acknowledge and agree that MYSTARTOUR retains the right to reformat, modify, create derivative works of, excerpt, and translate any User Submissions submitted by you. For clarity, the foregoing license grant to MYSTARTOUR does not affect your ownership of or right to grant additional non-exclusive licenses to the material in the User Submissions, unless otherwise agreed in writing; (e) You hereby represent and warrant that any content in your User Submission (including but not limited to text, graphics and photographs) do not infringe any applicable laws, regulations or any third party rights; and (f) That all the User Submissions publicly posted or privately transmitted through this Website is the sole responsibility of you and that MYSTARTOUR will not be liable for any errors or omissions in any content.

7. Users Representations, Warranties and Undertakings

7.1 Use of this Website and the Services
You represent, warrant and undertake to MYSTARTOUR that you will not provide any User Submissions or otherwise use this Website or the Services in a manner that: (a) Infringes or violates the intellectual property rights or proprietary rights, rights of publicity or privacy, or other rights of any third party; or (b) Violates any law, statute, ordinance or regulation; or (c) Is harmful, fraudulent, deceptive, threatening, abusive, harassing, tortious, defamatory, vulgar, obscene, libelous, or otherwise objectionable; or (d) Involves commercial activities and/or sales without MYSTARTOUR’s prior written consent such as contests, sweepstakes, barter, advertising, or pyramid schemes; or (e) Constitutes libel, impersonates any person or entity, including but not limited to any employee or representative of MYSTARTOUR; or (f) Contains a virus, trojan horse, worm, time bomb, or other harmful computer code, file, or program.

7.2 Removal of User Submissions
MYSTARTOUR reserves the right to remove any User Submissions from this Website at any time, for any reason including but not limited to, receipt of claims or allegations from third parties or authorities relating to such User Submission or if MYSTARTOUR is concerned that you may have breached any of the preceding representations, warranties or undertakings, or for no reason at all.

7.3 Responsibility for User Submissions
7.3.1 You remain solely responsible for all User Submissions that you upload, post, email, transmit, or otherwise disseminate using, or in connection with, this Website.
7.3.2 You acknowledge and agree that you shall be solely responsible for your own User Submissions and the consequences of posting or publishing all of your User Submissions on this Website. You represent, warrant and undertake to MYSTARTOUR that: (a) You own or have the necessary rights, licenses, consents, releases and/or permissions to use and authorize MYSTARTOUR to use all copyright, trademark or other proprietary or intellectual property rights in and to any User Submission to enable inclusion and use thereof as contemplated by this Website and this Terms of Use; and (b) Neither the User Submissions nor your posting, uploading, publication, submission or transmittal of the User Submission or MYSTARTOUR’s use of the User Submissions, or any portion thereof, on or through this Website and/or the Services will infringe, misappropriate or violate any third party’s patent, copyright, trademark, trade secret, moral rights or other proprietary or intellectual property rights, or rights of publicity or privacy, or result in the violation of any applicable law, rule or regulation.
7.3.3 You are responsible for all of your activity in connection with using this Website and/or the Services. You further represent, warrant and undertake to MYSTARTOUR that you shall not: (a) Conduct any fraudulent, abusive, or otherwise illegal activity which may be grounds for termination of your right to access or use this Website and/or the Services; or (b) sell or resell any products, services or reservation obtained from or via this Website or Mobile Application; (c) use this Website or Mobile Application for commercial or competitive activity or purposes, or for the purpose of making speculative, false or fraudulent bookings or any reservations in anticipation of demand; (d) Post or transmit, or cause to be posted or transmitted, any communication or solicitation designed or intended to obtain password, account, or private information from any other user of this Website; or (e) Violate the security of any computer network, crack passwords or security encryption codes, transfer or store illegal material (including material that may be considered threatening or obscene), or engage in any kind of illegal activity that is expressly prohibited; or (f) Run maillist, listserv, or any other form of auto-responder, or "spam" on this Website, or any processes that run or are activated while you are not logged on to this Website, or that otherwise interfere with the proper working of or place an unreasonable load on this Website’s infrastructure; or (g) Use manual or automated software, devices, or other processes to "crawl," "scrape," or "spider" any page of this Website; or (h) Decompile, reverse engineer, or otherwise attempt to obtain the source code of this Website.
7.3.4 You will be responsible for withholding, filing, and reporting all taxes, duties and other governmental assessments associated with your activity in connection with using this Website and/or the Services.

8. Registration and Security
8.1 Opening of the MYSTARTOUR Account 8.1.1 In the course of using the Services, you may be required to open and maintain an account with MYSTARTOUR (“MYSTARTOUR Account”).

8.2 Provision of Personal Information
8.2.1 As a condition to using some aspects of the Services, you may be required to register with MYSTARTOUR and select a password and username (“MYSTARTOUR User ID”). If you are accessing the Services through a Third Party Website or service, MYSTARTOUR may require that your MYSTARTOUR User ID be the same as your user name for such Third Party Website or service.
8.2.2 You shall provide MYSTARTOUR with accurate, complete, and updated registration information. Failure to do so shall constitute a breach of this Terms of Use, which may result in immediate termination of your MYSTARTOUR Account.
8.2.3 You represent that you shall not: (a) Select or use as a MYSTARTOUR User ID a name of another person with the intent to impersonate that person; or (b) Use as a MYSTARTOUR User ID a name subject to any rights of a person other than you without appropriate authorization.
8.2.4 MYSTARTOUR reserves the right to refuse registration of or to cancel a MYSTARTOUR Account at its sole discretion. You shall be responsible for maintaining the confidentiality of your password.

9. Reviews / Further correspondence / Rights to User Content
9.1. By completing a booking, you agree to receive confirmation messages (in the form of emails and/or app notifications), as well as an invitation email(s) or app notification(s) for you to complete our guest review form which we will send to you after you finish an activity. Leaving a review is optional. For clarity, the confirmation and guest review emails are transactional and are not part of the newsletters or marketing mails, from which you can unsubscribe. The completed guest review may be uploaded onto the relevant activity page on the MYSTARTOUR platform within 72 hours of the submission for the sole purpose of informing (future) customers of your opinion of the service (level) and quality of the Activity. Each account may only submit one review per activity booked once or multiple times within the same calendar month.

9.2. By posting a review, you grant MYSTARTOUR the full, perpetual, free, transferable and irrevocable rights to all submitted user content. MYSTARTOUR reserves the right to translate, edit, adjust, refuse or remove reviews at its sole discretion.

9.3. You confirm you will comply with these Guest Review Guidelines. In addition, you represent and warrant that
9.3.1. you own and control all of the rights to the user content that you post or otherwise distribute, or you otherwise have the lawful right to post and distribute such user content to or through the platform;
9.3.2. such content is accurate and not misleading; and
9.3.3. use and posting or other transmission of such content does not violate the Terms of Use or any applicable laws and regulations and will not violate any rights of or cause injury to any person or entity.

9.4. Reviews may not contain obscenities, profanity, inappropriate content, hate speech and offensive content, promotion of illegal conduct, other people’s personal information such as names, phone numbers or email addresses, and irrelevant content such as promotional, invite and reward information. Moreover, reviews may not defame, abuse, harass, or violate the legal rights of others. *

9.5. You further grant MYSTARTOUR the right to pursue at law any person or entity that violates your or MYSTARTOUR's rights in the content by a breach of the Terms of Use. You agree you will be solely responsible for any user content you provide or submit.

9.6. Content submitted by users will be considered non-confidential and MYSTARTOUR is under no obligation to treat such content as proprietary information. Without limiting the foregoing, MYSTARTOUR reserves the right to use the content as it deems appropriate, including, without limitation, deleting, editing, modifying, rejecting, or refusing to post it. MYSTARTOUR is under no obligation to offer you any payment for content that you submit or the opportunity to edit, delete or otherwise modify content once it has been submitted to MYSTARTOUR. MYSTARTOUR shall have no duty to attribute authorship of content to you, and shall not be obligated to enforce any form of attribution by third parties.

10. Booking Confirmation, Tickets, Vouchers, Fees and Payment
10.1 Booking Confirmation
Certain Services are stated to be subject to instant confirmation. Other than these Services, any required time for confirmation as stated on the Website is solely for reference only. Actual time required for confirmation may vary.

10.2 Purchase and Use of the Vouchers
10.2.1 Through this Website, you may purchase vouchers from MYSTARTOUR for the Services (“Vouchers”) offered by the Operators in the various destinations. Subject to the policy of the relevant Operator, you will receive an email confirmation of your purchase that will contain a Voucher confirmation number (“Confirmation Number”) and a printable version of your Voucher.
10.2.2 In order to use your Voucher, you must appear in person at the meeting point designated by the relevant Operator on time, and present such documents and/or information as may be required by the Operator, that may include your Confirmation Number and/or your printed Voucher. If you fail to appear on time or to provide the required documents or information, no refunds will be granted.
10.2.3 An Operator may also require you to provide an identification document bearing your photo in order to use your Voucher. Neither MYSTARTOUR nor the Operator is responsible for lost, destroyed or stolen Vouchers or Confirmation Numbers. Vouchers will be void if the relevant Services to be provided are prohibited by law. If you attempt to use a Voucher in an unlawful manner (e.g., you attempt to use a Voucher for wine tasting when you are under the legal age to do so), the respective Operator may refuse to accept your Voucher, and no refunds will be granted.

10.3 Terms of the Vouchers
10.3.1 The Terms of Use for each Voucher may vary amongst Operators and any restrictions that apply to the use of such Voucher, including but not limited to a minimum age requirement, will be conveyed to you at the time of purchase on the Website.
10.3.2 Vouchers are admission tickets to one-time events ('Events'): the date(s) on which a Voucher can be used will be stated on the Voucher. If you do not use your Vouchers on or by the date(s) noted on such Vouchers, except as expressly set forth therein, no refunds will be granted.

10.4 Cancelation of Vouchers
10.4.1 You may cancel your Voucher by contacting MYSTARTOUR customer service within the cancelation period, as stated at the time of purchase on the Website. Cancelation windows vary on a case by case basis. A Voucher canceled with the required notice will be refunded in full to the credit card you used to purchase such Voucher.
10.4.2 The Operator, not MYSTARTOUR, is the offeror of the Services for the Events, to which the Vouchers correspond to, and is solely responsible for accepting or rejecting any Voucher you purchase, as related to all such Services.
10.4.3 Please directly consult with the Operator if you have any enquiries or complaints in respect of the Service you received in connection with your Voucher. Except as expressly set forth herein, all fees paid for Vouchers are non-refundable. Prices quoted for Vouchers are in the currency stated on the Website at the time prior to purchase.
10.4.4 If an Event which you have purchased a Voucher for is canceled by the Operator, MYSTARTOUR will notify you as soon as reasonably practicable, and will process a full refund to the credit card you used to purchase such Voucher.

10.5 Required Assistance
If you attempt to use a Voucher in accordance with this Terms of Use and the additional terms and conditions applicable to such Voucher and you are unable to do so (due to the fault of the Operator or otherwise), please contact MYSTARTOUR at MYSTARTOURkorea@blankkorea.com, and MYSTARTOUR will try to liaise with the Operator for an appropriate remedy.

10.6 Additional Charges
MYSTARTOUR reserves the right to require payment of fees or charges for any Services offered by MYSTARTOUR. You shall pay all applicable fees or charges, as described on this Website in connection with such Services selected by you.

10.7 Modifications to Charges
MYSTARTOUR reserves the right to change its price list for fees or charges at any time, upon notice to you, which may be sent to you by email or posted on this Website. Your use, or continued use, of the Services offered by MYSTARTOUR following such notification constitutes your acceptance of any new or revised fees or charges.

10.8 MYSTARTOUR’s Rights and Obligations
10.8.1 MYSTARTOUR reserves the right to deny and cancel bookings or purchases of any Services that are deemed in violation of this policy. Such a determination is at MYSTARTOUR’s sole discretion.
10.8.2 MYSTARTOUR intends to offer or procure the Operators to offer the Services to you at the best price available on the market. You acknowledge and agree that all taxes and additional fees for particular Services that may be payable for using the Services are expressly excluded in determining the best price.
10.8.3 Whilst the Operators are required to provide MYSTARTOUR with accurate and updated prices of the Services on this Website, MYSTARTOUR cannot guarantee that all prices for the Services provided by the Operators are accurate and updated at all times.

10.9 The above terms and conditions & return policies are applicable to all MYSTARTOUR users worldwide.

11. Discounts
11.1 MYSTARTOUR Coupons
11.1.1 MYSTARTOUR Coupons are coupons with a one-time use and will not be returned if used that will be sent to your designated email address or applied directly to your MYSTARTOUR Account, which may be used in exchange for discounts of future bookings on the MYSTARTOUR Booking Platform. For the avoidance of doubt, once you have used the MYSTARTOUR Coupons on the MYSTARTOUR Booking Platform, such MYSTARTOUR Coupons will not be returned or refunded under any circumstances.
11.1.2 MYSTARTOUR Coupons may be attained through the following means: (a) You may receive MYSTARTOUR Coupons through the MYSTARTOUR Referral Program (b) You may receive MYSTARTOUR Coupons by other authorized means as determined at MYSTARTOUR’s sole discretion.


11.2 Abuse of Discounts
In the event where it has come to MYSTARTOUR’s attention that the MYSTARTOUR Coupons were earned in a fraudulent manner, in a manner that violates this Terms of Use or in a manner otherwise not intended by MYSTARTOUR, MYSTARTOUR reserves the right to the following: (a) Termination of your MYSTARTOUR Account with immediate effect; or (b) Cancelation of all MYSTARTOUR Credits or MYSTARTOUR Coupons as previously accrued; or (c) Refusal of the provision of the Services to you; or (d) Any other measures as deemed appropriate by MYSTARTOUR at its sole discretion.


12. Indemnity
12.1 MYSTARTOUR’s Indemnification
You will indemnify and hold MYSTARTOUR, our holding companies, subsidiaries, affiliates, officers, directors and employees harmless from, including but not limited to all damages, liabilities, settlements, costs and attorney’s fees, claims or demands made by any third party due to or arising out of your access to this Website, use of this Website, your violation of this Terms of Use, or the infringement of any intellectual property or other right of any person or entity by you or any third party using your MYSTARTOUR User ID.

12.2 MYSTARTOUR’s Involvement
MYSTARTOUR may, if necessary, participate in the defense of any claim or action and any negotiations for settlement. You will not make any settlement that may adversely affect the rights or obligations of MYSTARTOUR without MYSTARTOUR’s prior written approval. MYSTARTOUR reserves the right, at its expense and upon notice to you to assume exclusive defense and control of any claim or action.

13. Disclaimers and Limitation of Liability
13.1 Parties’ Relationship
MYSTARTOUR has no special relationship with or fiduciary duty to you for accessing and using this Website and the Content. You acknowledge that MYSTARTOUR has no control over, and no duty to take any action regarding: (a) Which users gain access to this Website; (b) What content you access via this Website; (c) What effect the Content may have on you; (d) How you may interpret or use the Content; and (e) What actions you may take as a result of having been exposed to the Content.

13.2 Services and Comments
You acknowledge and agree that the Operators may offer the Services on this Website, and that suggestions or recommendations may be given by the Operators or Users of this Website. MYSTARTOUR makes no representations or warranties regarding the accuracy of descriptions anywhere on the Services, or regarding suggestions or recommendations of the Services offered or purchased through this Website.

13.3 Exemption of Liability
13.3.1 In no event will MYSTARTOUR, this Website, or any of MYSTARTOUR’s holding companies, subsidiaries, affiliates, officers, directors and/or employees be liable for any loss of profits or any indirect, consequential, special, incidental, or punitive damages arising out of, based on, or resulting from: (a) This Website; or (b) This Terms of Use; or (c) Any breach of this Terms of Use by you or a third party; or (d) Use of this Website, tools or Services we provide related to the business we operate on this Website by you or any third party; or (e) Any actual or attempted communication or transaction between users, in each case, even if we have been advised of the possibility of such damages.
13.3.2 These limitations and exclusions apply without regard to whether the damages arise from: (a) Breach of contract; or (b) Breach of warranty; or (c) Strict liability; or (d) Tort; or (e) Negligence; or (f) Any other cause of action, to the maximum extent that such exclusion and limitations are not prohibited by applicable law.
13.3.3 This Website, including all content, software, functions, materials and information made available on or accessed through this Website, is provided on an "as is" basis. To the fullest extent permissible by applicable law, MYSTARTOUR makes no representations or warranties of any kind, either express or implied, including but not limited to the content on this Website or the materials, information and functions made accessible through this Website, for any of the Services or hypertext links to third parties or for any breach of security associated with the transmission of sensitive information through this Website, or for Operator ability, fitness for a particular purpose, non-infringement, or that the use of the Services will be uninterrupted or error-free.
13.3.4 You acknowledge and agree that any transmission to and from this Website is not confidential and your communications may be read or intercepted by others. You further acknowledge and agree that by submitting communications to MYSTARTOUR and by posting information on this Website, including tours and/or activities, no confidential, fiduciary, contractually implied or other relationship is created between you and MYSTARTOUR other than pursuant to this Terms of Use.
13.3.5 You acknowledge and agree that you will not hold or seek to hold MYSTARTOUR responsible for the content provided by any Operator or third party and you further acknowledge and agree that MYSTARTOUR is not a party to any transaction in relation to the Services provided by any Operator or third party. MYSTARTOUR has no control over and does not guarantee the safety of any transaction, tours and/or activities or the truth or accuracy of any listing or other content provided by any Operator or third party on this Website.

13.4 Remedies
13.4.1 If you are dissatisfied with this Website, do not agree with any part of this Terms of Use, or have any other dispute or claim with or against MYSTARTOUR or another user of this Website with respect to this Terms of Use or this Website, your sole and exclusive remedy against MYSTARTOUR is to discontinue use of this Website.
13.4.2 In any event, to the fullest extent permissible by the applicable law, MYSTARTOUR’s liability, and the liability of any member of MYSTARTOUR, to you or any third party in any circumstance arising out of or in connection with this Website is limited to the greater of: (a) The amount of fees you paid to MYSTARTOUR in the twelve months prior to the action giving rise to liability; or (b) USD Dollars 100.00 in the aggregate for all claims.

14. Interaction with Third Parties
14.1 Links to Third Party Websites
14.1.1 This Website may contain links to third party websites or services  that are not owned or controlled by MYSTARTOUR, or the Services may be accessible by logging in through a Third Party Website. Links to Third Party Websites do not constitute an endorsement or recommendation by MYSTARTOUR of such Third Party Websites or the information, products, advertising or other materials available on those Third Party Websites.
14.1.2 When you access Third Party Websites, you do so at your own risk. You hereby represent and warrant that you have read and agree to be bound by all applicable policies of any Third Party Websites relating to your use of the Services and that you will act in accordance with those policies, in addition to your obligations under this Terms of Use.
14.1.3 MYSTARTOUR has no control over, and assumes no responsibility for, the content, accuracy, privacy policies, or practices of or opinions expressed in any Third Party Websites. In addition, MYSTARTOUR will not and cannot monitor, verify, censor or edit the content of any Third Party Website. By using the Services, you expressly relieve and hold MYSTARTOUR harmless from any and all liability arising from your use of any Third Party Website.
14.1.4 Your interactions with organizations and/or individuals found on or through the Services including but not limited to the Operators, including payment and delivery of goods or services, and any other terms, conditions, warranties or representations associated with such dealings, are solely between you and such organizations and/or individuals.
14.1.5 You should conduct whatever investigation you feel necessary or appropriate before proceeding with any online or offline transaction with any of these third parties.

14.2 MYSTARTOUR’s Responsibility
You agree that MYSTARTOUR shall not be responsible or liable for any loss or damage of any sort incurred as the result of any such dealings. If there is a dispute between participants on this site, or between users and any third party, you understand and agree that MYSTARTOUR is under no obligation to become involved. In the event that you have a dispute with one or more other users or third parties, you hereby release MYSTARTOUR, its holding companies, subsidiaries, officers, directors, employees, agents, and successors in rights from claims, demands, and damages (actual and consequential) of every kind or nature, known or unknown, suspected or unsuspected, disclosed or undisclosed, arising out of or in any way related to such disputes.

15. Payment
In order to ensure adequate operational support for customers in respect of refunds and cancellations (where applicable), the following MYSTARTOUR entities shall be responsible for transactions conducted in DOJCKOREA Corporation.

16. Termination
16.1 Termination by MYSTARTOUR
This Terms of Use shall remain in full force and effect while you use this Websites or the Services. MYSTARTOUR may terminate or suspend your access to the Services or your membership at any time, for any reason, and without notice, which may result in the forfeiture and destruction of all information associated with your membership. MYSTARTOUR may also terminate or suspend any and all Services and access to this Website immediately, without prior notice or liability, if you breach any of the terms or conditions of this Terms of Use.

16.2 Effects of Termination
16.2.1 Upon termination of your MYSTARTOUR Account, your right to use the Services, access this Website, and any Content will immediately cease. All provisions of this Terms of Use which, by their nature, should survive termination, shall survive termination, including but not limited to ownership provisions, warranty disclaimers, and limitations of liability.
16.2.2 If this Terms of Use is terminated as a result of your breach, MYSTARTOUR reserves the right to cancel any outstanding Vouchers you may have purchased prior to said termination, without refund or liability to you.

17. Passports, Visas & Insurances

17.1 Your Responsibilities
17.1.1 It is the responsibility of all passengers, regardless of nationality and destination, to check with the consulate of the country they are visiting for current entry requirements.
17.1.2 As visa and health requirements are subject to changes without notice, MYSTARTOUR recommends that you verify health and visa requirements with the appropriate consulate prior to departure.
17.1.3 MYSTARTOUR strongly recommends that you purchase a comprehensive travel insurance policy prior to departure.

18. Governing Law

18.1 This Terms of Use shall be governed by the laws of Republic of Korea. You agree to submit to the non-exclusive jurisdiction of the Republic of Korea court.

19. Miscellaneous
19.1 Severability
If any provision of this Terms of Use is found to be unenforceable or invalid, that provision shall be limited or eliminated to the minimum extent necessary so that this Terms of Use shall otherwise remain in full force and effect and enforceable.
19.2 Assignment
This Terms of Use is not assignable, transferable or sub-licensable by you except with MYSTARTOUR’s prior written consent. MYSTARTOUR may transfer, assign or delegate this Terms of Use and its rights and obligations without prior notice to you.
19.3 The Terms of Use have been drafted, and shall be construed, in the English language. Any translation of the Terms of Use is solely for reference only. In the event of inconsistency between the English language version and a translated version, the English language version of the Terms of Use shall always prevail.

20. Privacy Policy
20.1 Privacy Policy
For MYSTARTOUR’s policy relating to its use of of your personal data, please review MYSTARTOUR’s current Privacy Policy, which is hereby incorporated by reference to this Terms of Use. Your acceptance of this Terms of Use constitutes your acceptance and agreement to be bound by our Privacy Policy.

21. Contact

21.1 Please contact MYSTARTOUR at MYSTARTOURkorea@blankkorea.com to report any violations of this Terms of Use or to pose any questions regarding this Terms of Use or the Service.
        </div>
      </div>
      <script type="text/javascript">
        $( document ).ready(function() {
          $('.trigger').click(function(){
            $('#popup_layer, #overlay_t').show();
            $('#popup_layer').css("top",(($(window).height() - $('#popup_layer').outerHeight()) / 2) + $(window).scrollTop());
            $('#popup_layer').css("left",(($(window).width() - $('#popup_layer').outerWidth()) / 2) + $(window).scrollLeft());
          });
          $('.trigger2').click(function(){
            $('#popup_layer2, #overlay_t').show();
            $('#popup_layer2').css("top",(($(window).height() - $('#popup_layer2').outerHeight()) / 2) + $(window).scrollTop());
            $('#popup_layer2').css("left",(($(window).width() - $('#popup_layer2').outerWidth()) / 2) + $(window).scrollLeft());
          });
          //close
          $('#overlay_t, .close').click(function(e){
            e.preventDefault();
            $('#popup_layer, #overlay_t').hide();
            $('#popup_layer2, #overlay_t').hide();
          });
          $('.p-close, .close').click(function(e){
            e.preventDefault();
            $('#popup_layer, #overlay_t').hide();
            $('#popup_layer2, #overlay_t').hide();
          });
        });
        $(document).ready(function(){
				$('.pop_con').css("overflow-y", "scroll");
				$('.pop_con').css("overflow-x", "hidden");
		    });
      </script>
      <style type="text/css">
        #overlay_t { background-color: #000; bottom: 0; left: 0; opacity: 0.5; filter: alpha(opacity = 50); /* IE7 & 8 */ position: fixed; right: 0; top: 0; z-index: 99; display:none;}
        .pop_layer { width:600px; height:400px; background:#fff; border:solid 1px #ccc; position:absolute; box-shadow: 0px 1px 20px #333; z-index:100; display:none;}
        .pop_layer h2 {color:#EC8AAB; font-size:2.0em; font-weight:400;}
        .pop_layer span {color:#FFF; background-color:#EC8AAB; float:right; font-weight:700; padding:2px 6px 4px; margin-top:8px; line-height:20px; cursor:pointer;}
        .pop_con {color:#000; border:1px solid #CCC; margin-top:15px; font-size:1.2em; height:300px;}
      </style>
		</article>
	</footer>
</body>
</html>

<?php
$sec = get_microtime() - $begin_time;
$file = $_SERVER['SCRIPT_NAME'];

if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}
?>



<script src="<?php echo G5_JS_URL; ?>/sns.js"></script>
<!-- } 하단 끝 -->


<?php
include_once(G5_PATH.'/tail.sub.php');
?>
