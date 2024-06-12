<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Green Tech | Landing Page</title>
  <link rel="stylesheet" href="<?= base_url(); ?>assets/css/main.min.css">
  <link rel="shortcut icon" href="<?= base_url(); ?>assets/img/LOGO BULAT.png">

  <!-- AOS -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

  <!-- Theme Color -->
  <meta name="theme-color" content="#002929">
  <!-- <meta name="theme-color" content="#0d6efd"> -->
  <style>
    #jumbotron {
      background: linear-gradient(rgba(0, 0, 0, .5), rgba(0, 0, 0, .5)),
        url(/assets/img/bg3.jpg);
      background-size: cover;
      background-attachment: fixed;
      background-position: center;
      min-height: 75vh;
      color: white;
    }

    #speakers .card-body,
    #invited-speakers .card-body {
      min-height: 325px;
    }

    #speakers .card,
    #invited-speakers .card {
      transition: all 0.3s ease-in-out;
    }

    #speakers .card:hover,
    #invited-speakers .card:hover,
    #workflow .card:hover {
      box-shadow: var(--bs-box-shadow-lg);
      transform: scale(1.05);
    }

    ::selection {
      background-color: var(--bs-primary);
      color: white;
    }

    .table>:not(caption)>*>* {
      color: unset;
    }

    #workflow .card-body {
      min-height: 350px;
    }

    #workflow .card {
      transition: all 0.3s ease-in-out;
      border: 1px solid var(--bs-primary);
    }

    #posts .conference-item .card {
      opacity: 1 !important;
      top: 50%;
    }

    #posts .conference-item:hover img {
      transform: scale(0.825);
    }

    #posts .conference-item:hover .card {
      transform: scale(0.9);
    }

    #posts .conference-item {
      cursor: pointer;
    }

    #posts .conference-item img {
      transform: scale(.75);
    }

    #posts img,
    #posts .card {
      transition: all 0.3s ease-in-out;
    }

    .nav-link.active {
      border-bottom: var(--bs-border-width) var(--bs-border-style) var(--bs-border-color) !important;
    }
  </style>
</head>

<body id="home" data-bs-spy="scroll" data-bs-target="#navbar" data-bs-smooth-scroll="true">

  <!-- NAVBAR -->
  <div class="position-relative" style="height: 75px;">
    <nav class="navbar navbar-expand-xl bg-dark navbar-dark fixed-top shadow" id="navbar">
      <div class="container">
        <a class="navbar-brand" href="<?= base_url(); ?>home.html">
          <img src="<?= base_url(); ?>assets/img/LOGO_TRANSPARAN.png" alt="" height="50" class="d-inline-block align-text-top">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
          <div class="navbar-nav">
            <a class="nav-link" href="#jumbotron">Home</a>
            <a class="nav-link" href="#about">About</a>
            <a class="nav-link" href="#speakers">Speakers</a>
            <a class="nav-link" href="#scopes">Scopes</a>
            <a class="nav-link" href="#dates">Events</a>
            <a class="nav-link" href="#publication">Publication</a>
            <a class="nav-link" href="#workflow">Workflow</a>
            <a class="nav-link" href="#comittee">Comittee</a>
            <a class="nav-link" href="#fee">Fee</a>
            <a class="nav-link" href="#submissions">Submissions</a>
            <a class="nav-link" href="#contact">Contact</a>
            <?php if (!session()->has('user')) : ?>
              <div class="nav-link"><a class="btn btn-primary" href="<?= base_url('auth'); ?>">Sign In</a></div>
            <?php else : ?>
              <div class="nav-link"><a class="btn btn-primary" href="<?= base_url('profile'); ?>">My Profile</a></div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </nav>
  </div>
  <!-- END OF NAVBAR -->

  <!-- JUMBOTRON -->
  <section id="jumbotron" class="py-5 text-center d-flex align-items-center">
    <div class="container">
      <!-- <img src="<?= base_url(); ?>assets/img/LOGO_TRANSPARAN.png" alt="" class="img-fluid mb-3" style="width: 300px;"> -->
      <h3 class="display-4" data-aos="zoom-in" data-aos-delay="750">THE 14TH INTERNATIONAL CONFERENCE ON GREEN
        TECHNOLOGY (ICGT)</h3>
      <div class="lead" data-aos="zoom-in" data-aos-delay="1000">
        <h5 class="mb-5">"Emerging Green Technology: A Path Towards Resilient and
          Sustainable Built Environment"</h5>
        <h5>October 2024 - Hybrid Meeting</h5>
        <h5 class="mb-5">Malang, Indonesia</h5>
      </div>
      <!-- <a href="<?= base_url('auth/register'); ?>" class="btn btn-primary mt-3 btn-lg" data-aos="zoom-in" data-aos-delay="1500">Register</a> -->
    </div>
  </section>
  <!-- END OF JUMBOTRON -->

  <!-- COUNTDOWN -->
  <section id="countdown" class="bg-light py-5 text-primary">
    <div class="container">
      <div class="row text-center">
        <div class="col-md-3" data-aos="fade-down" data-aos-duration="500" data-aos-delay="0">
          <div class="card mb-3">
            <div class="card-body text-muted">
              <h1 class="display-1" id="days">0</h1>
              <p>Days</p>
            </div>
          </div>
        </div>
        <div class="col-md-3" data-aos="fade-down" data-aos-duration="500" data-aos-delay="250">
          <div class="card mb-3">
            <div class="card-body text-muted">
              <h1 class="display-1" id="hours">0</h1>
              <p>Hours</p>
            </div>
          </div>
        </div>
        <div class="col-md-3" data-aos="fade-down" data-aos-duration="500" data-aos-delay="500">
          <div class="card mb-3">
            <div class="card-body text-muted">
              <h1 class="display-1" id="minutes">0</h1>
              <p>Minutes</p>
            </div>
          </div>
        </div>
        <div class="col-md-3" data-aos="fade-down" data-aos-duration="500" data-aos-delay="750">
          <div class="card mb-3">
            <div class="card-body text-muted">
              <h1 class="display-1" id="seconds">0</h1>
              <p>Seconds</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- END OF COUNTDOWN -->

  <!-- ABOUT -->
  <section id="about" class="py-5">
    <div class="container">
      <h3 class="display-4 text-center text-muted">About 14th ICGT 2024</h3>
      <div class="row align-items-center text-muted">
        <div class="col-lg-6" data-aos="fade-right">
          <img src="<?= base_url(); ?>assets/img/menpro-01.png" alt="" class="img-fluid rounded mb-3">
          <p class="text-justify text-muted">
            It is our pleasure to welcome you to the 2024 14th International Conference of Green Technology (ICGT 2024)
            in Malang, Indonesia. The ICGT is an annual multidisciplinary meeting for cultivating and promoting
            interactions between educators, scientists, engineers, and industry researchers in studying the development
            of science & technology and related area. In the last decade, educators and scientists concerned about how
            to discipline integration can be achieved and shifted from traditional methods that focused on science,
            technology, engineering, and mathematics as isolated disciplines. Therefore, “Emerging Green Technology: A
            Path Towards Resilient and Sustainable Built Environment” become the theme of The 14th ICGT 2024.
          </p>
        </div>
        <div class="col-lg-6" data-aos="fade-left">
          <p class="text-justify">The scientific programs consist of keynote lectures, plenary lectures, and invited
            lectures in parallel sessions covering a wide range of topics in STEM areas. A major goal of these
            conferences introduce students to learning and working in the STEM world, keep experts in the STEM field
            aware of current developments, and provide exchange their research results about most aspects of science and
            technology. We expected ICGT to play an important role in preparing all attendees to be leaders in STEM
            fields and solve the current practical challenges encountered from various perspectives.</p>
          <p class="text-justify">
            Faced with our new way of living, the 14th ICGT 2024 will be held fully hybrid on Malang, from October 1 and
            2, 2024. These hybrid conferences are held with a limited number of virtual participants and push for a
            return-to-physically meeting. All participants will have the same opportunities to present work either
            virtually or on-site, in Malang Indonesia.
          </p>
          <p class="text-justify">
            Participants who want to present their papers should submit their full papers. Only selected papers will be
            presented at the conferences. The review process will take at most one month. The deadline for full paper
            submission will be on September 1, 2024, and the selected full paper will be published in the Conference
            Proceedings by IOP Conference Series: Earth and Environmental Science indexed by Scopus.
          </p>
        </div>
      </div>
    </div>
    </div>
  </section>
  <!-- END OF ABOUT -->

  <!-- SPEAKERS -->
  <section id="speakers" class="py-5 bg-light">
    <div class="container">
      <div class="row">
        <h3 class="display-4 mb-5 text-primary text-center">Keynote Speakers</h3>
        <div class="col-lg-4">
          <div class="card mb-3">
            <div class="card-body d-block d-lg-flex gap-2 align-items-center flex-lg-row">
              <div class="mb-3 mb-lg-0" style="flex: 8;">
                <h3>Prof. Gunawan Prayitno SP. MT. Ph.D</h3>
                <p class="text-muted">Urban and Regional Planning Departement, Faculty of Engineering, Brawijaya
                  University, Malang</p>
                <span class="badge text-bg-primary">Indonesia</span>
              </div>
              <div class="text-center" style="flex: 4;">
                <img src="<?= base_url(); ?>assets/img/Prof.-Gunawan-Prayitno-SP.-MT.-Ph.D-300x300.png" class="img-fluid mb-3">
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card mb-3">
            <div class="card-body d-block d-lg-flex gap-2 align-items-center flex-lg-row">
              <div class="mb-3 mb-lg-0" style="flex: 8;">
                <h3>Ir. Agung Murti Nugroho, ST., MT., Ph.D, IPM</h3>
                <p class="text-muted">Architecture Department, Faculty of Engineering, Brawijaya University, Malang</p>
                <span class="badge text-bg-primary">Indonesia</span>
              </div>
              <div class="text-center" style="flex: 4;">
                <img src="<?= base_url(); ?>assets/img/Ir.-Agung-Murti-Nugroho-ST.-MT.-Ph.D-IPM-300x300.png" class="img-fluid mb-3">
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card mb-3">
            <div class="card-body d-block d-lg-flex gap-2 align-items-center flex-lg-row">
              <div class="mb-3 mb-lg-0" style="flex: 8;">
                <h3>Arie Dipareza Syafei, Dr.Eng, ST., MEPM</h3>
                <p class="text-muted">Department of Environmental Engineering, Faculty of Civil Planning and Geo
                  Engineering, ITS, Surabaya</p>
                <span class="badge text-bg-primary">Indonesia</span>
              </div>
              <div class="text-center" style="flex: 4;">
                <img src="<?= base_url(); ?>assets/img/Arie-Dipareza-Syafei-Dr.Eng-ST.-MEPM-300x300.png" class="img-fluid mb-3">
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card mb-3">
            <div class="card-body d-block d-lg-flex gap-2 align-items-center flex-lg-row">
              <div class="mb-3 mb-lg-0" style="flex: 8;">
                <h3>Assoc. Prof. LAr. Dr. Nor Atiah Ismail</h3>
                <p class="text-muted">Department of Landscape Architecture, Faculty of Design and Architecture,
                  Universiti Putra</p>
                <span class="badge text-bg-primary">Malaysia</span>
              </div>
              <div class="text-center" style="flex: 4;">
                <img src="<?= base_url(); ?>assets/img/Assoc.-Prof.-LAr.-Dr.-Nor-Atiah-Ismail-300x300.png" class="img-fluid mb-3">
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card mb-3">
            <div class="card-body d-block d-lg-flex gap-2 align-items-center flex-lg-row">
              <div class="mb-3 mb-lg-0" style="flex: 8;">
                <h3>Asst. Prof. Sunaree Lawanyawatna</h3>
                <p class="text-muted">School for Architecture and Design, King Mongkut's University of Technology
                  Thonburi</p>
                <span class="badge text-bg-primary">Thailand</span>
              </div>
              <div class="text-center" style="flex: 4;">
                <img src="<?= base_url(); ?>assets/img/Asst.-Prof.-Sunaree-Lawanyawatna-300x300.png" class="img-fluid mb-3">
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card mb-3">
            <div class="card-body d-block d-lg-flex gap-2 align-items-center flex-lg-row">
              <div class="mb-3 mb-lg-0" style="flex: 8;">
                <h3>Prof. Dr. Boriana Mihailova</h3>
                <p class="text-muted">Mineralogisch-Petrographisches Institut, Fakultät für Mathematik, Informatik und
                  Naturwissenschaften, Universität Hamburg</p>
                <span class="badge text-bg-primary">Germany</span>
              </div>
              <div class="text-center" style="flex: 4;">
                <img src="<?= base_url(); ?>assets/img/Prof.-Dr.-Boriana-Mihailova-300x300.png" class="img-fluid mb-3">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section id="invited-speakers" class="bg-light pb-5">
    <div class="container">
      <div class="row justify-content-center">
        <h3 class="display-4 text-center mb-5 text-primary">Invited Speakers</h3>
        <div class="col-lg-4">
          <div class="card mb-3 d-none d-lg-block" style="background-image: url(<?= base_url(); ?>assets/img/pattern.png);background-position: center;background-size: cover;">
            <div class="card-body d-block d-lg-flex gap-2 align-items-center flex-lg-row">

            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card mb-3">
            <div class="card-body d-block d-lg-flex gap-2 align-items-center flex-lg-row">
              <div class="mb-3 mb-lg-0" style="flex: 8;">
                <h3>Dr. Aulia Fikriarini Muchlis</h3>
                <p class="text-muted">Department of Architecture Engineering, Faculty of Science and Technology, State
                  Islamic University Maulana Malik Ibrahim Malang</p>
                <span class="badge text-bg-primary">Indonesia</span>
              </div>
              <div class="text-center" style="flex: 4;">
                <img src="<?= base_url(); ?>assets/img/Dr.-Aulia-Fikriarini-Muchlis-300x300.png" class="img-fluid mb-3">
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card mb-3 d-none d-lg-block" style="background-image: url(<?= base_url(); ?>assets/img/pattern.png);background-position: center;background-size: cover;">
            <div class="card-body d-block d-lg-flex gap-2 align-items-center flex-lg-row">

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- END OF SPEAKERS -->

  <!-- SCOPE -->
  <section id="scopes" class="py-5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6">
          <h3 class="display-4 mb-5 text-muted">Conference Scope</h3>
          <ul class="list-group mb-5">
            <li class="list-group-item list-group-item-action">
              <h5 class="text-muted">
                Natural Science
              </h5>
              <p class="text-muted">Science and Mathematics Toward Sustainable Living</p>
            </li>
            <li class="list-group-item list-group-item-action">
              <h5 class="text-muted">
                Engineering, Earth, and Information Science
              </h5>
              <p class="text-muted">Sustainable Industrialization, Advance Material, and Foster Innovation</p>
            </li>
            <li class="list-group-item list-group-item-action">
              <h5 class="text-muted">
                Technology, Energy, and Environmental Science
              </h5>
              <p class="text-muted"> Adaptive Technology for Energy Efficiency and Climate Change</p>
            </li>
            <li class="list-group-item list-group-item-action">
              <h5 class="text-muted">
                Architecture, Planning, and Environmental Engineering
              </h5>
              <p class="text-muted">Sustainable Architecture and Cities</p>
            </li>
          </ul>
        </div>
        <div class="col-lg-6" data-aos="fade-left">
          <img src="<?= base_url(); ?>assets/img/menpro-02.png" alt="Photo" class="img-fluid mb-5 m-lg-0 rounded">
        </div>
      </div>
    </div>
  </section>
  <!-- END OF SCOPE -->

  <!-- IMPORTANT DATES -->
  <section id="dates" class="py-5 bg-light">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col">
          <h3 class="display-4 mb-5 text-primary text-center">Important Dates</h3>
          <div class="card" data-aos="fade-down" data-aos-delay="250">
            <div class="card-body">
              <table class="table text-muted table-hover">
                <thead>
                  <tr>
                    <th></th>
                    <th>Event Descriptions</th>
                    <th>Available On</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>Extended Abstract Submission Deadline<br></td>
                    <td>August, 1 - 20 2024</td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>Extended Abstract Notification</td>
                    <td>August, 20 2024</td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td>Early Bird Registration</td>
                    <td>August, 20 - 25 2024</td>
                  </tr>
                  <tr>
                    <td>4</td>
                    <td>Late Registration</td>
                    <td>September, 15 2024</td>
                  </tr>
                  <tr>
                    <td>5</td>
                    <td>Presentation Material Submission</td>
                    <td>September, 25 - 28 2024</td>
                  </tr>
                  <tr>
                    <td>6</td>
                    <td>Conference Dates</td>
                    <td>October, 1- 2 2024</td>
                  </tr>
                  <tr>
                    <td>7</td>
                    <td>Full Paper Submission Deadline</td>
                    <td>October, 16 2024</td>
                  </tr>
                  <tr>
                    <td>8</td>
                    <td>Full Paper Review</td>
                    <td>October, 16 - November, 14 2024</td>
                  </tr>
                  <tr>
                    <td>9</td>
                    <td>LoA Proceeding ISSN &amp; Journal</td>
                    <td>November, 15 2024</td>
                  </tr>
                  <tr>
                    <td>10</td>
                    <td>Submission Acknowledgment for IOP Proceeding and Payment</td>
                    <td>November, 15 - 21 2024</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- END OF IMPORTANT DATES -->

  <!-- PUBLICATION -->
  <section id="publication" class="py-5">
    <div class="container text-muted text-justify">
      <h3 class="display-4 mb-5 text-center">Publication</h3>
      <div class="row">
        <div class="col-lg-6" data-aos="fade-right">
          <p>
            Selected papers <strong>(with an additional publication fee)</strong> will be published in an
            international
            proceeding. Please note that it is crucial to follow the publication process according to the conference
            system
            procedures (including revising your paper according to the reviewer's comments, and submitting a revised
            paper
            before the deadline in the system) to get your paper published in the proceeding and please note that your
            revised paper is the final version. The editors and the publication team may make
            some
            changes before the paper is sent to the publisher.
          </p>
          <p>
            Selected papers from participants of the 14th International Conference on Green Technology (ICGT)
            will be
            published in the following proceeding and journals:
          </p>
          <ol>
            <li><a href="https://publishingsupport.iopscience.iop.org/ees-forthcoming-volumes/">IOP Earth and
                Environmental
                Science</a> (Scopus Indexed). Follow <a href="https://publishingsupport.iopscience.iop.org/author-guidelines-for-conference-proceedings/">author's
                guidelines</a> and <a href="https://cms.iopscience.iop.org/alfresco/d/d/workspace/SpacesStore/f67538ae-18b2-11e4-831a-29411a5deefe/WordGuidelines.zip">template</a>
              when preparing your manuscript. <strong>The publication fee is IDR 2.300K (USD
                160)</strong><strong>*</strong><strong>.</strong></li>
            <li>Proceedings of the International Conference on Green Technology p-ISSN:&nbsp;<a href="http://u.lipi.go.id/1499324727">2580-7080</a>&nbsp;| e-ISSN: <a href="http://u.lipi.go.id/1492488213">2580-7099</a>. Use&nbsp;the<a href="https://docs.google.com/document/d/1pB1LXaLrz8UkHCTA1yBdlhbtlu0HX7Gw/edit?usp=sharing&amp;ouid=111164733078765689077&amp;rtpof=true&amp;sd=true">&nbsp;<strong>template</strong></a>&nbsp;when
              preparing the manuscript.</li>
          </ol>
        </div>
        <div class="col-lg-6" data-aos="fade-left">
          <ol start="3">
            <li><u>JIA (Journal of Islamic Architecture)</u> ** (Scopus Indexed). Follow the author guideline Use
              the<strong> <u>template</u> </strong>when preparing the manuscript. The publication fee is IDR 3.500K (USD
              220).</li>
            <li><a href="http://ejournal.uin-malang.ac.id/index.php/NEUTRINO/index">Jurnal Neutrino</a>: Jurnal Fisika
              dan
              Aplikasinya (Accredited SINTA-3) <a href="https://drive.google.com/file/d/1GGkckssxq3ZHaNzJFQcfw3MsEWm1JLpS/view"><em>Download Neutrino
                  template
                  here</em></a>.</li>
            <li><a href="http://ejournal.uin-malang.ac.id/index.php/Kimia">ALCHEMY</a>: Journal of Chemistry (Accredited
              SINTA-3) <a href="http://www.mediafire.com/file/hoohwqt1wn0306a/Template+Alchemy+Journal+of+Chemistry+2016+English.rtf"><em>Download
                  ALCHEMY template here</em></a><em>.</em></li>
            <li><a href="http://ejournal.uin-malang.ac.id/index.php/bio">El-Hayah</a><span>:
                Journal
                of Biology (Accredited SINTA-3) </span><a href="https://drive.google.com/file/d/0BwpXexUYUAGQY0dGU0hTYXpRd0E/view"><em>Download El-Hayah template
                  here</em></a><span>.</span></li>
          </ol>
          <p>*<strong> <em>Article Publication Charge (APC) is chargeable for articles accepted and declined by IOP
                editors. </em></strong><em>Please submit the <u>publication agreement</u> using the conference
              submission system.<br></em><em>**limited quota and only for appropriate articles
              and within the <u>scope</u> of the Journal of Islamic Architecture</em><span>&nbsp;</span></p>
        </div>
      </div>
    </div>
  </section>
  <!-- END OF PUBLICATION -->

  <!-- WORKFLOW -->
  <section id="workflow" class="py-5 bg-light">
    <div class="container">
      <h3 class="display-4 text-center text-primary mb-5">Conference Workflow</h3>
      <hr class="mb-5 border-primary">
      <div class="row flex-nowrap overflow-x-auto align-items-center gap-0">
        <div class="col-9 col-lg-3">
          <h3 class="mb-3 text-center">
            <button class="btn btn-primary btn-lg">
              <i class="bi bi-file-earmark"></i>
            </button>
          </h3>
          <h5 class="text-center text-muted">
            Abstract Submission
            </h3>
            <div class="card mb-5">
              <div class="card-body d-flex flex-column justify-content-center">
                <p class="text-muted text-center">
                  Presenters register with the submission system to get the article code and account then submit their
                  extended abstract using the submission system.
                </p>
              </div>
            </div>
        </div>
        <div class="col-1 text-center p-0">
          <i class="bi bi-arrow-right text-primary fs-1"></i>
        </div>
        <div class="col-9 col-lg-3">
          <h3 class="mb-3 text-center">
            <button class="btn btn-primary btn-lg">
              <i class="bi bi-pencil"></i>
            </button>
          </h3>
          <h5 class="text-center text-muted">
            Editor Review
            </h3>
            <div class="card mb-5">
              <div class="card-body d-flex flex-column justify-content-center">
                <p class="text-muted text-center">
                  The Committee will review the extended abstract (the relevance with the scope). The Accepted abstract
                  will be announced on the website via the submission system, and the Committee will send the LOA via
                  email to the Participants.
                </p>
              </div>
            </div>
        </div>
        <div class="col-1 text-center p-0">
          <i class="bi bi-arrow-right text-primary fs-1"></i>
        </div>
        <div class="col-9 col-lg-3">
          <h3 class="mb-3 text-center">
            <button class="btn btn-primary btn-lg">
              <i class="bi bi-credit-card"></i>
            </button>
          </h3>
          <h5 class="text-center text-muted">
            Payment
            </h3>
            <div class="card mb-5">
              <div class="card-body d-flex flex-column justify-content-center">
                <p class="text-muted text-center">
                  The presenter makes a contribution payment and uploads the payment receipt via the submission system.
                </p>
              </div>
            </div>
        </div>
        <div class="col-1 text-center p-0">
          <i class="bi bi-arrow-right text-primary fs-1"></i>
        </div>
        <div class="col-9 col-lg-3">
          <h3 class="mb-3 text-center">
            <button class="btn btn-primary btn-lg">
              <i class="bi bi-display"></i>
            </button>
          </h3>
          <h5 class="text-center text-muted">
            Presentation
            </h3>
            <div class="card mb-5">
              <div class="card-body d-flex flex-column justify-content-center">
                <p class="text-muted text-center">
                  The presenter uploads <a href="https://docs.google.com/presentation/d/1ES4c0MSnoZyJBaBZs7-PxjKlxpjc1OPB/edit?usp=sharing&amp;ouid=111662171596998431734&amp;rtpof=true&amp;sd=true" target="_blank" rel="noopener">presentation slides</a> via the submission system and delivers the
                  presentation orally at the conference, either onsite or online.
                </p>
              </div>
            </div>
        </div>
        <div class="col-1 text-center p-0">
          <i class="bi bi-arrow-right text-primary fs-1"></i>
        </div>
        <div class="col-9 col-lg-3">
          <h3 class="mb-3 text-center">
            <button class="btn btn-primary btn-lg">
              <i class="bi bi-clipboard2-check"></i>
            </button>
          </h3>
          <h5 class="text-center text-muted">
            Full Paper Submission
            </h3>
            <div class="card mb-5">
              <div class="card-body d-flex flex-column justify-content-center">
                <p class="text-muted text-center">
                  Presenter submit their full manuscript via the submission system, and the full paper will be
                  peer-reviewed via the submission system. For the IOP proceedings, each manuscript will need to be
                  uploaded into the IOP article submission system to be reviewed by the IOP editor.
                </p>
              </div>
            </div>
        </div>
      </div>
    </div>
  </section>
  <!-- END OF WORKFLOW -->

  <!-- COMITTEE -->
  <section id="comittee" class="py-5">
    <div class="container text-muted">
      <h3 class="display-4 text-center mb-5">Scientific Committee</h3>
      <div class="row">
        <div class="col-lg-6" data-aos="fade-right">
          <h5>Editor</h5>
          <ul class="mb-3 text-justify">
            <li>Prof. Ueki (Hiroshima University, Japan)</li>
            <li>Dr. Panupong Tamachoti (Chulalongkorn University, Bangkok, Thailand)</li>
            <li>Dr. Anton Prasetyo, M.Si (State Islamic University Maulana Malik Ibrahim Malang, Indonesia)</li>
            <li>Dr. Ajeng Kusumaningtyas Pramono (Gifu University, Japan)</li>
            <li>Dr. Erna Hastuti, M.Si (State Islamic University Maulana Malik Ibrahim Malang, Indonesia)</li>
            <li>Dr. Agus Subaqin, M.T. (State Islamic University Maulana Malik Ibrahim Malang, Indonesia)</li>
          </ul>
          <h5>Reviewer</h5>
          <ul class="text-justify">
            <li>Assoc. Prof. LAr. Dr. Nor Atiah Ismail (Universiti Putra Malaysia, Malaysia)</li>
            <li>Prof. Agung Sedayu, M.T (State Islamic University Maulana Malik Ibrahim Malang, Indonesia)</li>
            <li>Prof. Ulfah Utami, M.Si (State Islamic University Maulana Malik Ibrahim Malang, Indonesia)</li>
          </ul>
        </div>
        <div class="col-lg-6" data-aos="fade-left">
          <ul class="text-justify">
            <li>Prof. Dr. Bayyinatul Muchtaromah, M.Si (State Islamic University Maulana Malik Ibrahim Malang,
              Indonesia)</li>
            <li>Dr. Imam Tazi , M.Si (State Islamic University Maulana Malik Ibrahim Malang, Indonesia)</li>
            <li>Dr. Fachrul Kurniawan, M.Si (State Islamic University Maulana Malik Ibrahim Malang, Indonesia)</li>
            <li>Dr. Elly Susanti, M.Sc (State Islamic University Maulana Malik Ibrahim Malang, Indonesia)</li>
            <li>Dr. Aulia Fikriarini Muchlis, M.T. (State Islamic University Maulana Malik Ibrahim Malang, Indonesia)
            </li>
            <li>Dr. Mokhamad Amin Hariyadi, M.T. (State Islamic University Maulana Malik Ibrahim Malang, Indonesia)</li>
            <li>FX.Teddy Badai Samodra, ST., MT., Ph,D (Institut Teknologi Sepuluh Nopember, Indonesia)</li>
            <li>Ir. Agung Murti Nugroho, ST., M.T., Ph,D (Brawijaya University, Indonesia)</li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <!-- COMITTEE -->

  <!-- FEE -->
  <section id="fee" class="py-5 bg-light">
    <div class="container">
      <h3 class="display-4 mb-5 text-center text-primary">Conference Fee</h3>
      <div class="card" data-aos="fade-down" data-aos-delay="250">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover text-muted">
              <thead>
                <tr>
                  <th></th>
                  <th>Participant Type
                  </th>
                  <th>Early Bird</th>
                  <th>Regular</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>Online Presenter</td>
                  <td>
                    <p>LOCAL: IDR 400K</p>
                    <p>INTERNATIONAL: USD 50</p>
                  </td>
                  <td>
                    <p>LOCAL: IDR 450K</p>
                    <p>INTERNATIONAL: USD 55</p>
                  </td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>On Site Presenter</td>
                  <td>
                    <p>LOCAL: IDR 750K</p>
                    <p>INTERNATIONAL: USD 100</p>
                    STUDENT:
                    <ul>
                      <li>Under graduate: IDR 500 K</li>
                      <li>Master and doctoral: IDR 750K</li>
                    </ul>
                  </td>
                  <td>
                    <p>LOCAL: IDR 900K</p>
                    <p>INTERNATIONAL: USD 120</p>
                    STUDENT:
                    <ul>
                      <li>Under graduate: IDR 550K</li>
                      <li>Master and doctoral student IDR 800K</li>
                    </ul>
                  </td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>Listener</td>
                  <td>
                    <p>LOCAL: IDR 750K</p>
                    <p>INTERNATIONAL: USD 100</p>
                  </td>
                  <td>
                    <p>LOCAL: IDR 800K</p>
                    <p>INTERNATIONAL: USD 105</p>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- END OF FEE -->

  <!-- SUBMISSIONS -->
  <section id="submissions" class="py-5">
    <div class="container text-muted">
      <h3 class="display-4 text-center mb-5">Submissions</h3>
      <div class="row">
        <div class="col-lg-6" data-aos="fade-right">
          <p class="text-justify">To submit an extended abstract, you are <strong>required to submit the abstract
              first</strong>. After the admin
            grants approval within <strong>1-2 day</strong><strong>s</strong>, you can proceed to <strong>submit the
              extended abstract under the </strong><strong>Extended Abstract Upload Document menu</strong>.</p>
          </p>
          <h5>Abstract Submission</h5>
          <ol class="text-justify mb-3">
            <li>To submit an abstract, you must <strong>register</strong> to the conference by creating an account
              through the system. Please create an account by clicking <a href="http://gcms.uin-malang.ac.id/"><strong>REGISTER</strong></a>&nbsp;and submit your abstract.</li>
            <li>The abstract submission form contains Title, author names, email, affiliation, keyword, and abstract
              body.</li>
            <li>The abstract must be written in English,&nbsp; including the introduction, the aim of the study,
              methods, results, and the conclusion.</li>
            <li>The Title should be no longer than 16 Words.</li>
            <li>The abstract should be no longer than 200 words.</li>
            <li>The keywords are 3 to 5 words, written in alphabetical order.</li>
            <li>See the <a href="http://greentech.uin-malang.ac.id/wp-content/uploads/2023/09/PARTICIPANT-GUIDE.pdf">participant
                guide</a> when submitting and revising the abstract.</li>
          </ol>
          <p class="text-justify">After the editor approves the scope within 1-2 days, you can <strong>submit the
              extended
              abstract under the
              Extended Abstract Upload Document menu.</strong></p>
          <h5>Extended Abstract Submission</h5>
          <ol class="text-justify">
            <li>Extended abstract must be written in English and according to&nbsp;<a href="https://sbcc.upi.edu/2024/info/download"><strong>EXTENDED ABSTRACT
                  TEMPLATE</strong></a><strong>.</strong></li>
            <li>Extended abstract must contain the following structure: <strong>Title, introduction, material and
                methods, results and discussion, conclusion and references</strong>.</li>
            <li>Extended abstract/s should be submitted only <strong>after the abstracts are </strong><strong>ACCEPTED
                by the editor</strong><strong>.</strong></li>
            <li>Extended abstract/s must be revised according to reviewer's comments.</li>
            <li>Extended abstract&nbsp;revision must be submitted through the system (author's account).</li>
            <li>Extended abstract must consist of 4-5 Pages only.</li>
            <li>The author's instructions and extended abstract template can be downloaded from the&nbsp;<a href="https://sbcc.upi.edu/2024/info/download"><strong>download page</strong></a>.</li>
          </ol>
        </div>
        <div class="col-lg-6" data-aos="fade-left">
          <h6>Note :</h6>
          <ul class="text-justify">
            <li>The whole submission process is done fully online (NOT by email) to guarantee smooth administration.
            </li>
            <li>We allow up to 2 papers per author (including as a co-author) unless there is a legitimate reason to
              include more.</li>
          </ul>
          <h5>Presentation Submission</h5>
          <ul class="text-justify">
            <li>Please notice that <strong>submitting/uploading the powerpoint (PPT) presentation file is mandatory for
                all presenters</strong>. Presenters who do not upload their powerpoint will not get the e-certificate.
            </li>
            <li>To submit your powerpoint presentation file (PPT), please&nbsp;<strong>login</strong>first to your
              account. Go to&nbsp;<strong>'Presentation Material'</strong>&nbsp;menu and You will
              find&nbsp;<strong>'Presentation File'</strong>&nbsp;menu on the the page, and&nbsp;<strong>click
                'Upload'</strong>&nbsp;to upload your powerpoint (PPT). Please&nbsp;<strong>upload the PDF version
                (.pdf) </strong>maximum 5Mb<strong> of your powerpoint presentation file (NOT .ppt or .pptx)</strong>.
            </li>
            <li>The powerpoint should be between <strong>7-8 slides</strong><span>,&nbsp;</span><strong>written in
                English</strong><span>&nbsp;</span><strong>using IEEE&nbsp;</strong><span>citation style. Please
                download and use the&nbsp;first slide&nbsp;template
                for&nbsp;conference&nbsp;theme and logos&nbsp;</span><a href="https://drive.google.com/drive/folders/1ISiJuFY33TQG_EaQ3lu5wi0gdANdQFnI?usp=sharing"><strong>here</strong>.</a><span>&nbsp;</span><a href="https://drive.google.com/drive/folders/1ISiJuFY33TQG_EaQ3lu5wi0gdANdQFnI?usp=sharing"><strong>Powerpoint
                  Template</strong></a><strong>.</strong></li>
            <li>Please follow the following&nbsp;<strong>powerpoint structure</strong>:</li>
            <li style="list-style-type: none;">
              <ol>
                <li>First slide: Title, Author(s), Affiliation(s).</li>
                <li>Slide 2-3: Introduction &amp; Literature Review</li>
                <li>Slide 4: Method</li>
                <li>Slide 5-6: Results and Discussion</li>
                <li>Slide 7: Conclusion</li>
                <li>Slide 8: References</li>
              </ol>
            </li>
            <li>Do not overcrowd the slides with too many text. Keep text to a minimum (6-8 lines per slide). The bullet
              points should be headlines, not paragraphs. Write in sentence fragments using key words, and keep your
              font size 24 or bigger.</li>
            <li>Make sure your powerpoint is easy on the eyes. Stay away from weird colors and busy backgrounds. Use
              easy-to-read fonts such as Arial and Calibri.</li>
            <li><span>Proofread to avoid misspelling of names or words.</span></li>
            <li>To the provided space on your user account <strong>(<a href="https://forms.gle/eKf6F9PX45k5GYek7" target="_blank" rel="noopener">see further instructions
                  below</a>).</strong></li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <!-- END OF SUBMISSIONS -->

  <!-- POSTS -->
  <section id="posts" class="py-5 bg-light">
    <div class="container">
      <h3 class="display-4 text-muted text-center">Previous Conferences</h3>
      <div class="row">

        <div class="col-md-4 conference-item mb-3 position-relative">
          <div class="text-center">
            <img src="<?= base_url(); ?>assets/img/greentech2015 - persegi.jpg" alt="greentech2015.jpg" class="mb-3 rounded w-100">
          </div>
          <div class="card position-absolute z-2 opacity-0 img-captions d-xl-block d-none">
            <div class="card-body px-5">
              <h3 class="fw-bold display-6 text-muted">The 8th ICGT</h3>
              <div class="text-muted">
                <p class="text-uppercase">INNOVATION IN ISLAMIC PERSPECTIVE FOR SUSTAINABLE DEVELOPMENT ACTION TOWARD
                  INTERNATIONAL CHALLENGES
                </p>
                <ul class="d-flex list-unstyled mt-auto justify-content-between">
                  <li class="d-flex align-items-center me-3">
                    <i class="bi bi-geo-fill me-3"></i>
                    <small>UIN Maulana Malik Ibrahim Malang</small>
                  </li>
                  <li class="d-flex align-items-center">
                    <i class="bi bi-calendar3 me-3"></i>
                    <small>2015</small>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4 conference-item mb-3 position-relative">
          <div class="text-center">
            <img src="<?= base_url(); ?>assets/img/greentech2017 - persegi.jpg" alt="greentech2017.jpg" class="mb-3 rounded w-100">
          </div>
          <div class="card position-absolute z-2 opacity-0 img-captions d-xl-block d-none">
            <div class="card-body px-5">
              <h3 class="fw-bold display-6 text-muted">The 6th ICGT</h3>
              <div class="text-muted">
                <p class="text-uppercase">Empowering Basic Science Researches for Islamic Green Technology Development
                </p>
                <ul class="d-flex list-unstyled mt-auto justify-content-between">
                  <li class="d-flex align-items-center me-3">
                    <i class="bi bi-geo-fill me-3"></i>
                    <small>UIN Maulana Malik Ibrahim Malang</small>
                  </li>
                  <li class="d-flex align-items-center">
                    <i class="bi bi-calendar3 me-3"></i>
                    <small>2018</small>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4 conference-item mb-3 position-relative">
          <div class="text-center">
            <img src="<?= base_url(); ?>assets/img/greentech2019 - persegi.jpg" alt="greentech2019.jpg" class="mb-3 rounded w-100">
          </div>
          <div class="card position-absolute z-2 opacity-0 img-captions d-xl-block d-none">
            <div class="card-body px-5">
              <h3 class="fw-bold display-6 text-muted">The 10th ICGT</h3>
              <div class="text-muted">
                <p class="text-uppercase">Empowering the 4.0 Industrial Revolution through Green Science and Technology
                </p>
                <ul class="d-flex list-unstyled mt-auto justify-content-between">
                  <li class="d-flex align-items-center me-3">
                    <i class="bi bi-geo-fill me-3"></i>
                    <small>Savana Hotel and Convention Malang</small>
                  </li>
                  <li class="d-flex align-items-center">
                    <i class="bi bi-calendar3 me-3"></i>
                    <small>2019</small>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4 conference-item mb-3 position-relative">
          <div class="text-center">
            <img src="<?= base_url(); ?>assets/img/greentech2021 - persegi.jpeg" alt="greentech2021.jpeg" class="mb-3 rounded w-100">
          </div>
          <div class="card position-absolute z-2 opacity-0 img-captions d-xl-block d-none">
            <div class="card-body px-5">
              <h3 class="fw-bold display-6 text-muted">The 11th ICGT</h3>
              <div class="text-muted">
                <p class="text-uppercase">
                  OPTIMIZING TECHNOLOGY FOR SUSTAINING PRODUCTIVITY <br>DURING COVID-19
                </p>
                <ul class="d-flex list-unstyled mt-auto justify-content-between">
                  <li class="d-flex align-items-center me-3">
                    <i class="bi bi-geo-fill me-3"></i>
                    <small>Zoom <br> Teleconference</small>
                  </li>
                  <li class="d-flex align-items-center">
                    <i class="bi bi-calendar3 me-3"></i>
                    <small>2021</small>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4 conference-item mb-3 position-relative">
          <div class="text-center">
            <img src="<?= base_url(); ?>assets/img/greentech2022 - persegi.jpg" alt="greentech2022.jpg" class="mb-3 rounded w-100">
          </div>
          <div class="card position-absolute z-2 opacity-0 img-captions d-xl-block d-none">
            <div class="card-body px-5">
              <h3 class="fw-bold display-6 text-muted">The 12th ICGT</h3>
              <div class="text-muted">
                <p class="text-uppercase">
                  Empowering innovative science and technology for future environmental perspective
                </p>
                <ul class="d-flex list-unstyled mt-auto justify-content-between">
                  <li class="d-flex align-items-center me-3">
                    <i class="bi bi-geo-fill me-3"></i>
                    <small>Savana Hotel and Convention Malang</small>
                  </li>
                  <li class="d-flex align-items-center">
                    <i class="bi bi-calendar3 me-3"></i>
                    <small>2022</small>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4 conference-item mb-3 position-relative">
          <div class="text-center">
            <img src="<?= base_url(); ?>assets/img/greentech2023 - persegi.jpeg" alt="greentech2023.jpeg" class="mb-3 rounded w-100">
          </div>
          <div class="card position-absolute z-2 opacity-0 img-captions d-xl-block d-none">
            <div class="card-body px-5">
              <h3 class="fw-bold display-6 text-muted">The 13th ICGT</h3>
              <div class="text-muted">
                <p class="text-uppercase">
                  Strengthening The Impact of STEM (Science Technology Engineering and Mathemathics) for Sustainable
                  Future
                </p>
                <ul class="d-flex list-unstyled mt-auto justify-content-between">
                  <li class="d-flex align-items-center me-3">
                    <i class="bi bi-geo-fill me-3"></i>
                    <small>Ijen Suites Resort and Convention</small>
                  </li>
                  <li class="d-flex align-items-center">
                    <i class="bi bi-calendar3 me-3"></i>
                    <small>2023</small>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
  <!-- END OF POSTS -->

  <!-- CONTACT -->
  <section id="contact" class="py-5">
    <div class="container">
      <h3 class="display-4 mb-5 text-center text-muted">Contact Us</h3>
      <div class="row flex-lg-row-reverse text-muted align-items-center">
        <div class="col-lg-6" data-aos="fade-left">
          <h3>Persons</h3>
          <ul class="mb-3">
            <li><a href="http://wa.me/6285655544977" target="_blank">Ana Ziyadatul Husna, M.Ars</a>
            </li>
            <li><a href="http://wa.me/628990477307" target="_blank">Angga Perdana, M. Ars</a></li>
          </ul>
          <h3>Payment</h3>
          <p>All payment should be transferred to:</p>
          <table class="w-100 mb-5">
            <tbody>
              <tr>
                <td>
                  Bank Name
                </td>
                <td> : </td>
                <td>Bank Rakyat Indonesia</td>
              </tr>
              <tr>
                <td>
                  Account Number
                </td>
                <td> : </td>
                <td>057701010458502</td>
              </tr>
              <tr>
                <td>
                  Account Name
                </td>
                <td> : </td>
                <td>Angga Perdana</td>
              </tr>
            </tbody>
          </table>
          <img src="<?= base_url(); ?>assets/img/bri-logo.png" alt="LOGO BRI" class="img-fluid mb-3">
        </div>
        <div class="col-lg-6 mb-3" data-aos="fade-right">
          <h3>Venue</h3>
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1975.7256563110893!2d112.60493378854807!3d-7.952225248018047!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e78836798cb0b17%3A0x52f15a858f4a4a06!2sFakultas%20Sains%20dan%20Teknologi%20-%20UIN%20Malang!5e0!3m2!1sid!2sus!4v1712247670056!5m2!1sid!2sus" style="border:0;width: 100%;" class="rounded" height="400" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>
    </div>
  </section>
  <!-- END OF CONTACT -->

  <!-- FOOTER -->
  <section id="footer" class="text-bg-dark py-5">
    <div class="container">
      <footer class="row gap-5">

        <div class="col-12 col-lg-2 mb-3">
          <img src="<?= base_url(); ?>assets/img/logo-saintek-putih-1-300x82.png" alt="LOGO SAINTEK" class="img-fluid mb-3">
          <p class="text-body-secondary">© 2024. All Rights Reserved.</p>
        </div>

        <div class="col">
          <div class="row">
            <div class="col mb-3">
              <p><a href="#home" class="text-white">Home</a></p>
              <p><a href="#about" class="text-white">About</a></p>
              <p><a class="text-white" href="#speakers">Speakers</a></p>
            </div>

            <div class="col mb-3">
              <p><a class="text-white" href="#scopes">Scopes</a></p>
              <p><a class="text-white" href="#dates">Events</a></p>
              <p><a href="#publication" class="text-white">Publication</a></p>
            </div>

            <div class="col mb-3">
              <p><a href="#workflow" class="text-white">Workflow</a></p>
              <p><a href="#comittee" class="text-white">Comittee</a></p>
              <p><a href="#fee" class="text-white">Fee</a></p>
            </div>

            <div class="col mb-3">
              <p><a href="#submissions" class="text-white">Submissions</a></p>
              <p><a href="#contact" class="text-white">Contact</a></p>
              <p><a href="<?= base_url(); ?>login.html" class="text-white">Register</a></p>
            </div>
          </div>
        </div>

      </footer>
    </div>
  </section>
  <!-- END OF FOOTER -->

  <!-- MODALS -->
  <div id="viewImageModal" class="position-fixed top-0 start-0 w-100" style="z-index: 1031; display: none;background-color: rgba(0, 0, 0, .5);opacity: 0;transition: opacity .5s ease-in-out;">
    <div class="container">
      <div class="row align-items-center justify-content-center overflow-y-auto py-5" style="height: 100vh;">
        <div class="col-8 col-lg-4 text-center">
          <img class="w-100 mb-3" src="<?= base_url(); ?>assets/img/404-error-animate.svg">
          <button class="btn btn-primary" onclick="closeViewImageModal()">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

  <!-- AOS SCRIPT -->
  <script>
    document.querySelectorAll('.display-4').forEach(el => {
      el.setAttribute('data-aos', 'fade-down');
    });

    const chainingAnimation = (el, delay) => {
      el.setAttribute('data-aos-duration', '500');
      el.setAttribute('data-aos-delay', delay);
    }

    const animateColumns = (animationName = 'fade-up', delayFunc = index => index * 250) => {
      return (col, i) => {
        col.setAttribute('data-aos', animationName);
        chainingAnimation(col, delayFunc(i));
      }
    }

    // select all cards in speakers section
    document.querySelectorAll('#speakers .col-lg-4').forEach(animateColumns());
    document.querySelectorAll('#invited-speakers .col-lg-4').forEach(animateColumns());

    // select all cards in workflow section
    document.querySelectorAll('#workflow .col-lg-3').forEach(animateColumns('fade-down'));

    // select all cards in posts section
    document.querySelectorAll('#posts .col-md-4').forEach(animateColumns('fade-down'));
    document.querySelectorAll('#posts .col-md-4 .card').forEach(animateColumns('fade-down', i => (i + 1) * 1000));

    // select all list items in scopes section
    document.querySelectorAll('#scopes li').forEach((li, i) => {
      li.setAttribute('data-aos', 'fade-right');
      chainingAnimation(li, i);
    });

    AOS.init({
      once: true,
      duration: 1000
    });
  </script>

  <!-- VIEW IMAGE SCRIPT -->
  <script>
    const modal = document.getElementById('viewImageModal');
    const modalImg = document.querySelector("#viewImageModal img");

    document.querySelectorAll('#posts .conference-item').forEach(col => {
      col.addEventListener('click', () => {
        modal.style.display = "block";
        setTimeout(() => {
          modal.style.opacity = "1";
        }, 100);
        modalImg.src = '<?= base_url(); ?>assets/img/' + col.querySelector('img').alt;
        document.body.style.overflow = "hidden";
      });
    });

    function closeViewImageModal() {
      modal.style.opacity = "0";
      setTimeout(() => {
        modal.style.display = "none";
        document.body.style.overflow = "auto";
      }, 500);
    }
  </script>

  <!-- COUNTDOWN SCRIPT -->
  <script>
    // Set the date we're counting down to
    const countDownDate = new Date("Oct 1, 2024 00:00:00").getTime();

    // Update the count down every 1 second
    const x = setInterval(function() {

      // Get today's date and time
      const now = new Date().getTime();

      // Find the distance between now and the count down date
      const distance = countDownDate - now;

      // Time calculations for days, hours, minutes and seconds
      const days = Math.floor(distance / (1000 * 60 * 60 * 24));
      const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((distance % (1000 * 60)) / 1000);

      // Display the result in the element with id="demo"
      document.getElementById("days").innerHTML = days;
      document.getElementById("hours").innerHTML = hours;
      document.getElementById("minutes").innerHTML = minutes;
      document.getElementById("seconds").innerHTML = seconds;

      // If the count down is finished, write some text
      if (distance < 0) {
        clearInterval(x);
        // Delete the countdown
        document.getElementById("countdown").style.display = "none";
      }
    }, 1000);
  </script>

</body>

</html>