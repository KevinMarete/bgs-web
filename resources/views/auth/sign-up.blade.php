<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content />
  <meta name="author" content />
  <title>Pharmahub | Sign-Up</title>
  <link href="css/styles.css" rel="stylesheet" />
  <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
  <script data-search-pseudo-elements defer src="libs/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
  <script src="libs/ajax/libs/feather-icons/4.24.1/feather.min.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Libre+Franklin:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&amp;display=swap" rel="stylesheet" />
</head>

<body class="bg-primary-img">
  <div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
      <main>
        <div class="container">
          @if (Session::has('bgs_msg'))
          {!! session('bgs_msg') !!}
          @endif
          <div class="row justify-content-center">
            <div class="col-lg-7">
              <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header justify-content-center">
                  <h3 class="font-weight-light my-4">Create Account</h3>
                </div>
                <div class="card-body">
                  <form action="/add-account" method="POST">
                    @csrf
                    <div class="form-row">
                      <div class="col-md-6">
                        <div class="form-group"><label class="small mb-1" for="inputFirstName">First Name</label><input class="form-control py-4" id="inputFirstName" type="text" placeholder="Enter first name" name="firstname" required /></div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group"><label class="small mb-1" for="inputLastName">Last Name</label><input class="form-control py-4" id="inputLastName" type="text" placeholder="Enter last name" name="lastname" required /></div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="small mb-1" for="selectOrganization">Organization</label>
                      <select class="form-control form-control-solid" aria-label="Organization Name" aria-describedby="organizationHelp" name="organization_id" required>
                        <option value="">Select Organization</option>
                        @foreach ($organizations as $organization)
                        <option value="{{ $organization['id'] }}">{{ $organization['name'] }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-row">
                      <div class="col-md-6">
                        <div class="form-group"><label class="small mb-1" for="inputEmailAddress">Email</label><input class="form-control py-4" id="inputEmailAddress" type="email" aria-describedby="emailHelp" placeholder="Enter email address" name="email" required /></div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group"><label class="small mb-1" for="inputPhone">Phone</label><input class="form-control py-4" id="inputPhone" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" aria-describedby="phoneHelp" placeholder="Enter phone number" name="phone" required /></div>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="col-md-6">
                        <div class="form-group"><label class="small mb-1" for="inputPassword">Password</label><input class="form-control py-4" id="inputPassword" type="password" placeholder="Enter password" name="password" required /></div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group"><label class="small mb-1" for="inputConfirmPassword">Confirm Password</label><input class="form-control py-4" id="inputConfirmPassword" type="password" placeholder="Confirm password" name="cpassword" required /></div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox">
                        <input type="hidden" name="is_mailing_list" value="false">
                        <input type="checkbox" class="custom-control-input" id="mailingList" name="is_mailing_list" value="true">
                        <label class="custom-control-label" for="mailingList"><strong>Subscribe to join our weekly promotions &amp; deals mailing list</strong></label>
                      </div>
                    </div>
                    <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" type="submit">Create Account</button></div>
                  </form>
                </div>
                <div class="card-footer text-center">
                  <p class="small"> By clicking <em>Create Account</em> you agree to our
                    <a href="#" data-toggle="modal" data-target=".terms-modal-lg">terms of service</a>
                  </p>
                  <div class="small"><a href="/sign-in">Have an account? Go to login</a></div>
                  <div class="small"><a href="/">Go to Main Page</a></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
    <div class="modal fade terms-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Terms of Use</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body m-2">
            <p class="text-justify">
              By using any Pharma Hub (PH) websites, mobile applications, or social media (collectively the “PH
              Platform”) or any of the text, graphics, name, trademarks, logo, user interfaces, visual interfaces,
              information, data, tools, products, services and other content (together, “Content”) contained therein,
              you hereby accept and agree to comply with the terms and conditions set forth in this Terms of Use.
            </p>
            <p class="text-justify">
              This Terms of Use is a binding agreement between you and PH, and governs your access and use of any
              part of the “PH Platform”, including this website (the “Site”), and any of the Content it contains.
            </p>
            <p class="text-justify">
              Throughout this policy, you will see the terms “Pharma Hub” “PH,” “we,” “our,” and “us” ­ these terms
              refer to Pharma Hub, a Massachusetts non-profit corporation with tax-exempt status pursuant to
              Internal Revenue Service Code Section 501(c)(3). You will also see the terms “I,” “you,” “your,” and
              “yours” – these terms refer to visitors to and users of our PH Platform or any of the content contained
              therein.
            </p>
            <p class="text-justify">
              Copyright and Permissions
            </p>
            <p class="text-justify">
              PH Copyrights
            </p>
            <p class="text-justify">
              In general, content on the PH Platform is protected by the copyright laws of the Republic of Kenya.
            </p>
            <p class="text-justify">
              What you may do without permission: Without asking our permission, you are welcome to print pages
              from this website and to download the files that are specifically offered in downloadable format
              (usually, PDF, Word, or PowerPoint). You may also use, without prior permission, text from posted press
              releases. You may also link to this website and its contents without permission; kindly let us know if you
              have done so.
            </p>
            <p class="text-justify">
              What you must request permission to do: If you want to reproduce, publish, or incorporate other text or
              images from this website into other websites, publications, or other materials that you or others
              produce, contact communications@PH.org for permission.
            </p>
            <p class="text-justify">
              For all materials and information used from our PH Platform, we ask that you credit original sources as
              given. If no other specific source or authorship information is shown, please credit the appropriate
              website.
            </p>
            <p class="text-justify">
              It is the user’s responsibility to be aware of current copyright law and applications. The user agrees to
              indemnify Pharma Hub from any costs or claims for infringement of copyright in relation to copies of
              images or text from our PH Platform.
            </p>
            <p class="text-justify">
              Digital Millennium Copyright ACT (“DMCA”) Notice
            </p>
            <p class="text-justify">
              PH is committed to complying with copyright and related laws, and requires all users of the PH Platform
              to comply with these laws. Accordingly, you may not store any material or content or use or disseminate
              any material or content though the PH Platform in any manner that constitutes an infringement of third
              party intellectual property rights, including rights granted by copyright law. Owners of copyrighted
              works who believe that their rights under copyright law have been infringed may take advantage of
              certain provisions of the Digital Millennium Copyright Act of 1998 (the “DMCA”) to report alleged
              infringements. You may not post, modify, distribute, or reproduce in any way any copyrighted material,
              trademarks, or other proprietary information belonging to others without obtaining the prior written
              consent of the owner of such proprietary rights. It is the policy of PH to terminate use privileges of any
              user who repeatedly infringes the copyright rights of others upon receipt of proper notification to PH by
              the copyright owner or the copyright owner’s legal agent.
            </p>
            <p class="text-justify">
              If you believe that your work has been copied and posted using the PH Platform in a way that
              constitutes copyright infringement, please contact info@pharmahub.africa
            </p>
            <p class="text-justify">
              Linking to the Pharma Hub Site and use of Content
            </p>
            <p class="text-justify">
              Please be aware: by copying and/or downloading Content from the PH Platform, you agree to be bound
              by the terms and conditions set forth in this Terms of Use and any other terms and conditions that may
              be outlined elsewhere on this Site. Without limiting any other terms or conditions, the permission to use
              the Pharma Hub Site and Content, including our name and the logo and/or links bearing the name and
              logo, is subject to the following:
            </p>
            <p class="text-justify">
              Use of the name and logo or links bearing the name and logo may not indicate or create an impression
              that Pharma Hub endorses, approves, sponsors or is affiliated with your products, goods, services, or
              your website.
            </p>
            <p class="text-justify">
              Your use of the name and logo or links bearing the name and logo may not indicate or create an
              impression that Pharma Hub will benefit from the sale of any of your goods or services.
              Links bearing the name and logo may only be used for the purpose of linking to our Site as designated
              within the link.
            </p>
            <p class="text-justify">
              The links bearing the name and logo will always be active links.
            </p>
            <p class="text-justify">
              The name and logo and/or link bearing the name and logo may not be combined with any other graphic
              elements; nor may they be altered in any manner including size, proportions, font, design, arrangement,
              colors, or elements; nor may they be animated, morphed, or otherwise distorted in perspective or
              appearance.
            </p>
            <p class="text-justify">
              The name and logo and/or link bearing the name and logo may not appear more prominently than your
              personal, company, product, or service website name.
              You will not transfer, assign, sell, reproduce, distribute, or otherwise exploit the name and logo or your
              link to us.
            </p>
            <p class="text-justify">
              The Pharma Hub name and logo and/or link bearing the name and logo may not appear on any pages of
              any website that include content or advertising for alcoholic beverages, tobacco, pornography, partisan
              material, political material, or firearms.
            </p>
            <p class="text-justify">
              Appropriate action by Pharma Hub may include, but is not limited to, the revocation of the right to use
              the name and logo and/or any links bearing the name and logo, in which event you agree to remove the
              name and logo and/or the links bearing the name and logo promptly, but in no event later than two
              business days of notice of revocation.
            </p>
            <p class="text-justify">
              It is improper, and may be a violation of law, for you to post or download and distribute any material
              that you do not own or for which you do not have permission to use. PLEASE BE AWARE: violation of
              someone’s copyright, trademark or other intellectual property rights may subject you to civil and/or
              criminal penalties.
            </p>
            <p class="text-justify">
              Inappropriate use of Pharma Hub Content
            </p>
            <p class="text-justify">
              It is inappropriate to use the PH Platform or Content for illegal, inappropriate, or obscene purposes, or
              in support of such activities. We define these terms as follows:
            </p>
            <p class="text-justify">
              “Illegal activities” are those that violate laws, regulations and/or private agreements, including federal
              or state laws governing charitable activities, copyright laws, trademark laws, license agreements or
              other intellectual property rights.
            </p>
            <p class="text-justify">
              “Inappropriate uses” are any uses other than as permitted by this Terms of Use, or as may be permitted
              elsewhere on our Site.
            </p>
            <p class="text-justify">
              “Obscene activities” are those that violate generally accepted social standards for use of this type of
              material or technology.
            </p>
            <p class="text-justify">
              PLEASE BE AWARE: PH MAY SEEK APPROPRIATE ACTION TO TERMINATE ANY USES OF OUR CONTENT
              INCLUDING, BUT NOT LIMITED TO, THE NAME AND LOGO AND LINKS BEARING OUR NAME AND LOGO IN
              THE EVENT WE, IN OUR SOLE DISCRETION, DETERMINE THAT YOUR USE DOES NOT CONFORM TO ANY
              OF THE CONDITIONS OF THIS TERMS OF USE OR AS PROVIDED ELSEWHERE ON OUR WEBSITE;
              INFRINGES ANY INTELLECTUAL PROPERTY OR OTHER RIGHTS OF PH OR A THIRD PARTY; ADVERSELY
              AFFECTS PH’S IMAGE, REPUTATION AND/OR OUR PRODUCTS, SERVICES, OR PROGRAMS; VIOLATES ANY
              APPLICABLE LAW, REGULATION OR ORDINANCE; AND/OR IS A PROHIBITED ACTIVITY.
            </p>
            <p class="text-justify">
              Listed below are some, but not all, prohibited activities that may result in action by Pharma Hub:
            </p>
            <p class="text-justify">
              Posting, transmitting, or facilitating in the promotion of illegal content through the PH Platform or
              Content.
            </p>
            <p class="text-justify">
              Using our PH Platform or our Content to harass, threaten, embarrass, or do anything else to another
              visitor or third party that is unwanted.
            </p>
            <p class="text-justify">
              Transmitting or facilitating distribution of content that is untrue, threatening, harassing, abusive, racially
              or ethnically offensive, vulgar, sexually explicit, obscene, defamatory, or objectionable.
            </p>
            <p class="text-justify">
              Security Notice
            </p>
            <p class="text-justify">
              For site security purposes and to ensure that the PH Platform remains available to all users, some
              elements of the PH Platform may employ software programs to monitor network traffic and identify
              unauthorized attempts to upload or change information or otherwise cause damage.
            </p>
            <p class="text-justify">
              Unauthorized attempts to upload information or change information on the PH Platform service are
              strictly prohibited and may be punishable under the Computer Fraud and Abuse Act of 1986 and the
              National Information Infrastructure Protection Act.
            </p>
            <p class="text-justify">
              Disclaimers
            </p>
            <p class="text-justify">
              Links to Other Sites
            </p>
            <p class="text-justify">
              The PH Platform may include links to websites of other organizations which, we believe, may offer
              relevant information. Once you link to another site, you are subject to the disclaimers and security and
              privacy policies of the new site.
            </p>
            <p class="text-justify">
              Disclaimer of Endorsement
            </p>
            <p class="text-justify">
              The documents posted on the PH Platform may contain hypertext links or pointers to information
              created and maintained by other public and private organizations. These links and pointers are provided
              for visitors’ convenience. We do not control or guarantee the accuracy, relevance, timeliness, or
              completeness of any linked information. Further, the inclusion of links or pointers to other websites is
              not intended to endorse, recommend, or favor any views expressed, or commercial products or services
              offered on these outside sites, or the organizations sponsoring the sites, by trade name, trademark,
              manufacture, or otherwise.
            </p>
            <p class="text-justify">
              Reference on the PH Platform to any specific commercial products, processes, or services, or the use of
              any trade, firm, or corporation name is for the information and convenience of the site’s visitors, and
              does not constitute endorsement, recommendation, or favoring by PH. The views and opinions of
              authors expressed on the PH Platform do not necessarily state or reflect those of the PH.
            </p>
            <p class="text-justify">
              Limitation of Liability
            </p>
            <p class="text-justify">
              TO THE MAXIMUM EXTENT PERMITTED BY LAW, IN NO EVENT WILL PH OR ITS
              DONORS/SUPPLIERS/LICENSORS BE LIABLE TO YOU OR ANY THIRD PARTY FOR ANY DIRECT, SPECIAL,
              INCIDENTAL, CONSEQUENTIAL, PUNITIVE, OR INDIRECT DAMAGES (WHETHER IN CONTRACT, TORT (INCLUDING NEGLIGENCE), OR OTHERWISE), WHICH INCLUDE, WITHOUT LIMITATION, DAMAGES FOR
              PERSONAL INJURY, LOST PROFITS, LOST DATA AND BUSINESS INTERRUPTION, ARISING OUT OF THE USE
              OF, OR INABILITY TO USE, THE SITE, EVEN IF PH HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH
              DAMAGES.
            </p>
            <p class="text-justify">
              Disclaimer of Liability
            </p>
            <p class="text-justify">
              PH makes no claims, promises, or guarantees about the accuracy, completeness, or adequacy of the
              contents of the PH Platform and expressly disclaims liability for errors and omissions in any of the
              contents of the PH Platform.
            </p>
            <p class="text-justify">
              With respect to the content of the PH Platform, PH makes no warranty, expressed or implied or
              statutory, including but not limited to the warranties of non-infringement of third-party rights, title, and
              the warranties of merchantability and fitness for a particular purpose, with respect to content available
              from the PH Platform or other Internet resources linked from it. Additionally, PH assumes no legal
              liability for the accuracy, completeness, or usefulness of any information, product, or process disclosed
              on the PH Platform or freedom from computer viruses, and does not represent that use of such
              information, product, or process would not infringe on privately owned rights.
            </p>
            <p class="text-justify">
              Warranty Disclaimer
            </p>
            <p class="text-justify">
              YOU EXPRESSLY AGREE THAT USE OF THE PH PLATFORM IS AT YOUR SOLE RISK AND YOU ASSUME ALL
              RISK. THE PH PLATFORM IS PROVIDED ON AN “AS AVAILABLE,” “AS IS” BASIS. TO THE MAXIMUM EXTENT
              PERMITTED BY LAW, PH AND ITS LICENSORS DISCLAIM ALL WARRANTIES WITH RESPECT TO THE PH
              PLATFORM, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF NON-INFRINGEMENT,
              TITLE, MERCHANTABILITY, QUIET ENJOYMENT, QUALITY OF INFORMATION, AND FITNESS FOR A
              PARTICULAR PURPOSE. PH DOES NOT WARRANT THAT THE PH PLATFORM WILL MEET YOUR
              REQUIREMENTS, OR THAT THE OPERATION OF THE PH PLATFORM WILL BE UNINTERRUPTED OR ERROR-
              FREE, OR THAT DEFECTS IN THE PH PLATFORM WILL BE CORRECTED. YOU SPECIFICALLY ACKNOWLEDGE
              THAT PH IS NOT LIABLE FOR THE DEFAMATORY, OFFENSIVE OR ILLEGAL CONDUCT OF OTHER USERS OR
              THIRD-PARTIES AND THAT THE RISK OF INJURY FROM THE FOREGOING RESTS ENTIRELY WITH YOU.
            </p>
            <p class="text-justify">
              Other Disclaimers
            </p>
            <p class="text-justify">
              The PH Platform and the information contained herein is provided for informational and educational
              purposes only, and could include technical inaccuracies or typographical errors.
            </p>
            <p class="text-justify">
              Information on the PH Platform is provided with the understanding that PH is not rendering professional
              advice or recommendations. You should not rely on any information on these pages to replace
              consultations with qualified professionals to meet your individual needs.
            </p>
            <p class="text-justify">
              <strong>Privacy Policy</strong>
            </p>
            <p class="text-justify">
              This policy describes how Pharma Hub (PH) goes about collecting, using, maintaining, protecting,
              and disclosing the information that it receives about you from your interaction with any PH websites,
              mobile applications, and social media (collectively the “PH Platform”).
            </p>
            <p class="text-justify">
              This policy may be changed at any time, in which case the revised Privacy Policy will apply to
              information collected after the date it is posted. By accessing the PH Platform, you agree that you
              have read and understand the terms and conditions of this Privacy Policy.
            </p>
            <p class="text-justify">
              PH has servers located in the United States and is subject to the applicable state and federal laws of
              the United States. If you choose to access the PH Platform, you consent to the use and disclosure of
              information you provide in accordance with this Privacy Policy and subject to such laws.
            </p>
            <p class="text-justify">
              The PH Platform is not intended for, and should not be used by, children under 13 years of age. PH
              does not knowingly collect personal information from children under 13, and in the event that PH
              learns that the personal information of a child under 13 has been collected or received, it will be
              deleted.
            </p>
            <p class="text-justify">
              Throughout this policy, you will see the terms “Pharma Hub ” “PH,” “we,” “our,” and “us” these terms
              refer to BEVMAJ GLOBAL SOLUTION LTD .You will also see the terms “I,” “you,” “your,” and “yours”
              – these terms refer to visitors to and users of our PH Platform or any of the content contained
              therein.
            </p>
            <p class="text-justify">
              Types of Information PH May Collect
            </p>
            <p class="text-justify">
              PH may collect several types of information from and about users of our PH Platform, including:
            </p>
            <p class="text-justify">
              <ul>
                <li>Personal Information you choose to provide. We do not collect any personally identifiable
                  information about you unless you voluntarily submit such information to us, by, for example,
                  filling out forms, creating an account on PH’s websites or on other components of the PH
                  Platform, or making a donation.</li>
                <li>Information regarding financial transactions, made through our website.</li>
                <li>Records and copies of your correspondence (including email addresses), if you contact us.</li>
                <li>Information about your Internet connection, the equipment you use to access components of
                  our PH Platform, and usage details including:</li>
                <li>traffic data, location data logs, and other communication data and the resources that
                  you access and use on the PH Platform.</li>
                <li>your IP address, operating system, and browser type.</li>
              </ul>
            </p>
            <p class="text-justify">
              Ways that PH May Collect Information
            </p>
            <p class="text-justify">
              PH may collect information either directly from you the user, and/or automatically as you navigate
              through the PH Platform. Information collected automatically may include usage details, IP
              addresses, and information collected through Google Analytics.
            </p>
            <p class="text-justify">
              PH only collects Personal Information when voluntarily and knowingly submitted by a visitor. You
              can have general access to our PH Platform and browse websites describing our organization
              without providing any Personal Information or being required to register. If you choose to make a
              donation to PH, whether by telephone, postal mail, or an PH website, we will collect certain required
              financial information from you (such as your credit card information if you choose to submit your
              donation in that manner, and the donation amount).
            </p>
            <p class="text-justify">
              Online donations are processed by a third-party service provider and you should read the section of
              our Terms of Use entitled “Links to Other Sites” and familiarize yourself with the privacy terms of all
              such non-PH sites before using them.
            </p>
            <p class="text-justify">
              Users may provide information to be published or displayed on public areas of the PH Platform, or
              transmitted to other users of the PH Platform. This information posted on and transmitted to others
              at your own risk.
            </p>
            <p class="text-justify">
              Some elements of the PH Platform use “cookies” which are small pieces of data that are sent to your
              browser from PH’s web server and stored on your computer’s hard drive for the purpose of collecting
              non-identifying information about you as a user, such as Web surfing behavior or user preferences
              for a specific website.PH does not link information obtained through the use of cookies to individual
              user’s personal information.
            </p>
            <p class="text-justify">
              Some web tracking information may include data, such as IP address data, that is unique to you.
              You can manually delete all cookies within your browser privacy settings. You can also set your
              browser to not accept cookies although this may prevent you from using some of the services
              offered on the PH Platform.
            </p>
            <p class="text-justify">
              How PH May Use the Information it Collects
            </p>
            <p class="text-justify">
              PH may use the information that it collects in the following ways:
            </p>
            <p class="text-justify">
              <ul>
                <li>To help PH present the PH Platform components and their contents to users.</li>
                <li>To provide users with information that they request from PH.</li>
                <li>To fulfill any other purpose for which the user provided the information.</li>
                <li>In any other way that is described when a user provides the information.</li>
                <li>For any other purpose with the user’s consent.</li>
              </ul>
            </p>
            <p class="text-justify">
              From time to time PH may disclose aggregated information about our users, and information that
              does not identify any individual, without restriction.
            </p>
            <p class="text-justify">
              PH may also disclose Personal Information that is collected as described above:
            </p>
            <p class="text-justify">
              <ul>
                <li>To comply with any court order, law, or legal process, including to respond to any
                  government or regulatory request.</li>
                <li>To our subsidiaries and affiliates.</li>
                <li>To contractors, service providers, and other third parties who support PH and its charitable
                  purposes, who are bound by contractual obligations to keep personal information confidential
                  and use it only for the purposes for which PH disclosed it to them.</li>
                <li>To fulfill the purpose for which the user provided it.</li>
                <li>For any other purpose disclosed by PH when the user provided the information.</li>
                <li>With the user’s consent.</li>
              </ul>
            </p>
            <p class="text-justify">
              How PH Protects Personal Information
            </p>
            <p class="text-justify">
              PH uses reasonable security precautions to protect the security and integrity of user’s Personal
              Information in accordance with this Privacy Policy and applicable law.
            </p>
            <p class="text-justify">
              PH encrypts transmissions of personal information through our websites using secure socket layer
              technology (SSL) but cannot guarantee the security of personal information transmitted to the PH
              Platform.
            </p>
            <p class="text-justify">
              Unfortunately, the transmission of information via the Internet is not completely secure. Although we
              do our best to protect your personal information, we cannot guarantee the security of personal
              information transmitted to our websites or other PH Platform components. Any transmission of
              personal information is at your own risk. Without limitation of the foregoing, we are not responsible
              for the actions of hackers and other unauthorized third parties that breach our reasonable security
              procedures.
            </p>
            <p class="text-justify">
              How Users Can Access and Correct Personal Information
            </p>
            <p class="text-justify">
              Users can review and change any of the Personal Information they provided when registering for an
              account on the PH Platform by logging into the appropriate website and visiting their account profile
              page.
            </p>
            <p class="text-justify">
              For any other concerns regarding user information that was submitted via the PH Platform contact :
              info@pharmahub.africa.
            </p>
            <p class="text-justify">
              If a user deletes his/her contributions from the PH Platform, copies may remain viewable in cached
              and archived pages, or might have been copied or stored by other website users.
            </p>
            <p class="text-justify">
              For More Information
            </p>
            <p class="text-justify">
              If you have any questions or comments about this privacy policy, please contact PH at the address,
              phone number, or e-mail address listed below.
            </p>
            <p class="text-justify">
              <address>
                <strong>BEVMAJ GLOBAL SOLUTIONS LTD</strong><br>
                CHAI ESTATE 16, JUJA<br>
                KENYA<br />
              </address>
            </p>
            <p class="text-justify">
              Telephone: +254722226549
            </p>
            <p class="text-justify">
              Email: info@pharmahub.africa
            </p>
            </p>
          </div>
        </div>
      </div>
    </div>
    <div id="layoutAuthentication_footer">
      <footer class="sb-footer py-4 mt-auto sb-footer-dark">
        <div class="container-fluid">
          <div class="d-flex align-items-center justify-content-between small">
            <div>Copyright &copy; Pharmahub {{date('Y')}}</div>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <script src="libs/jquery/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
  <script src="libs/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="libs/jplist/1.2.0/jplist.min.js"></script>
  <script src="/libs/jquery-ui/jquery-ui.min.js"></script>
  <script src="/libs/multidatespicker/jquery-ui.multidatespicker.js"></script>
  <script src="/libs/bootstrap-multiselect/js/bootstrap-multiselect.js"></script>
  <script src="/libs/daterangepicker/js/moment.min.js"></script>
  <script src="/libs/daterangepicker/js/daterangepicker.js"></script>
  <script src="/libs/select2/js/select2.min.js"></script>
  <script src="/libs/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
  <script src="js/scripts.js"></script>

  <!--
        <script src="js/sb-customizer.js"></script>
        <sb-customizer project="sb-admin-pro"></sb-customizer>
        -->
</body>

</html>