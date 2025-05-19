$(document).ready(function () {
  // Doctor data (in a real app, this would come from a database)
  const doctors = {
    1: {
      name: "Dr. Muhammad Ilyas",
      title: "Cardiologist",
      img: "../assets/images/Doctor-8.webp",
      bio: "DDr. Muhammad Ilyas is a board-certified cardiologist with over 15 years of experience in treating complex heart conditions. He specializes in interventional cardiology and has performed over 2,000 successful angioplasties.",
      education: [
        "MBBS - Khyber Medical University",
        "FCPS (Cardiology) - College of Physicians and Surgeons Pakistan",
        "Fellowship in PIC",
      ],
      specializations: [
        "Interventional Cardiology",
        "Heart Failure",
        "Hypertension",
      ],
      availability:
        "Monday to Friday: 9:00 AM - 5:00 PM, Saturday: 9:00 AM - 1:00 PM",
      badges: [
        { text: "MBBS", class: "bg-primary" },
        { text: "10+ Years", class: "bg-success" },
        { text: "Interventional", class: "bg-info" },
      ],
    },
    2: {
      name: "Dr.ghulam farooq",
      title: "Cardiac Surgeon",
      img: "../assets/images/Doctor-9.jpeg",
      bio: "Dr.ghulam farooq is a renowned cardiac surgeon specializing in coronary artery bypass grafting and valve replacement surgeries. She has successfully performed over 1,500 open-heart surgeries.",
      education: [
        "MBBS - Aga Khan University",
        "FRCS (Cardiothoracic Surgery) - Royal College of Surgeons, UK",
        "Fellowship in Minimally Invasive Cardiac Surgery PIc",
      ],
      specializations: [
        "Coronary Artery Bypass",
        "Valve Replacement",
        "Aortic Surgery",
      ],
      availability: "Tuesday to Saturday: 10:00 AM - 6:00 PM",
      badges: [
        { text: "MBBS", class: "bg-primary" },
        { text: "12+ Years", class: "bg-success" },
        { text: "Surgeon", class: "bg-danger" },
      ],
    },
    3: {
      name: "Prof. Dr. Khawar Abbas",
      title: "Pulmonologist",
      img: "../assets/images/Doctor-11.webp",
      bio: "Prof. Dr. Khawar Abbas is a specialist in pulmonary medicine with expertise in sleep disorders and critical care. He has published numerous research papers on COPD management.",
      education: [
        "MBBS - Khyber Medical University",
        "FCPS (Pulmonology) - College of Physicians and Surgeons Pakistan",
        "Fellowship in Sleep Medicine - LHR Peshawar",
      ],
      specializations: ["COPD", "Sleep Apnea", "Critical Care"],
      availability: "Monday to Friday: 8:00 AM - 4:00 PM",
      badges: [
        { text: "MD", class: "bg-primary" },
        { text: "10+ Years", class: "bg-success" },
        { text: "Sleep Specialist", class: "bg-warning text-dark" },
      ],
    },
    4: {
      name: "Dr. Anwar Ullah",
      title: "Neurologist",
      img: "../assets/images/Doctor-4.png",
      bio: "Dr. Anwar Ullah is a board-certified neurologist specializing in stroke management and epilepsy treatment. She has extensive experience in neurological disorders.",
      education: [
        "MBBS - Khyber Medical University",
        "FCPS (Neurology) - College of Physicians and Surgeons Pakistan",
        "Fellowship in Stroke Neurology - Massachusetts General Hospital, USA",
      ],
      specializations: [
        "Stroke Management",
        "Epilepsy",
        "Movement Disorders",
      ],
      availability: "Monday to Thursday: 9:00 AM - 4:00 PM",
      badges: [
        { text: "MD", class: "bg-primary" },
        { text: "8+ Years", class: "bg-success" },
        { text: "Stroke Specialist", class: "bg-info" },
      ],
    },
    5: {
      name: "Dr. Islam Hussain",
      title: "Orthopedic Surgeon",
      img: "../assets/images/Doctor-5.png",
      bio: "Dr. Islam Hussain is an experienced orthopedic surgeon specializing in joint replacements and arthroscopic surgery. He has performed over 500 successful joint replacements.",
      education: [
        "MBBS - Aga Khan University",
        "FRCS (Orthopedics) - Royal College of Surgeons, UK",
        "Fellowship in Joint Replacement - Hospital for Special Surgery, USA",
      ],
      specializations: [
        "Joint Replacement",
        "Arthroscopic Surgery",
        "Trauma",
      ],
      availability: "Sunday to Thursday: 10:00 AM - 6:00 PM",
      badges: [
        { text: "FRCS", class: "bg-primary" },
        { text: "10+ Years", class: "bg-success" },
        { text: "Joint Specialist", class: "bg-danger" },
      ],
    },
    6: {
      name: "Dr. Sanaullah",
      title: "Sports Medicine",
      img: "../assets/images/Doctor-6.png",
      bio: "Dr. Sanaullah specializes in sports medicine and rehabilitation. He works with athletes of all levels to help them recover from injuries and improve performance.",
      education: [
        "MBBS - Khyber Medical University",
        "Diploma in Sports Medicine - ISAKOS",
        "Fellowship in Sports Medicine - Aspetar, Qatar",
      ],
      specializations: [
        "Sports Injuries",
        "Rehabilitation",
        "Performance Enhancement",
      ],
      availability: "Monday to Friday: 8:00 AM - 3:00 PM",
      badges: [
        { text: "MD", class: "bg-primary" },
        { text: "7+ Years", class: "bg-success" },
        { text: "Sports Specialist", class: "bg-warning text-dark" },
      ],
    },
    7: {
      name: " Dr. Irfan Ullah Shah",
      title: "Dental Surgeon",
      img: "../assets/images/Doctor-6.png",
      bio: "Dr. Irfan Ullah Shah is a cosmetic dentist specializing in dental implants and smile makeovers. She uses the latest techniques for pain-free dental treatments.",
      education: [
        "BDS - Khyber College of Dentistry",
        "MSc in Cosmetic Dentistry - King's College London",
        "Diploma in Implantology - AAID",
      ],
      specializations: [
        "Cosmetic Dentistry",
        "Dental Implants",
        "Oral Surgery",
      ],
      availability: "Monday to Saturday: 9:00 AM - 5:00 PM",
      badges: [
        { text: "BDS", class: "bg-primary" },
        { text: "5+ Years", class: "bg-success" },
        { text: "Implant Specialist", class: "bg-info" },
      ],
    },
    8: {
      name: "Dr. Haroon Shah",
      title: "Pathologist",
      img: "../assets/images/doctors/doctor8.jpg",
      bio: "Dr. Haroon Shah is a senior pathologist with extensive experience in clinical pathology and laboratory medicine. He oversees all laboratory operations.",
      education: [
        "MBBS - Khyber Medical University",
        "FCPS (Pathology) - College of Physicians and Surgeons Pakistan",
        "Fellowship in Clinical Pathology - Mayo Clinic, USA",
      ],
      specializations: [
        "Clinical Pathology",
        "Hematology",
        "Microbiology",
      ],
      availability: "Monday to Friday: 8:00 AM - 4:00 PM",
      badges: [
        { text: "MD", class: "bg-primary" },
        { text: "12+ Years", class: "bg-success" },
        { text: "Lab Director", class: "bg-secondary" },
      ],
    },
  };

  // Learn More button functionality
  $(".learn-more-btn").click(function () {
    const dept = $(this).data("dept");
    const doctorSection = $("#" + dept + "-doctors");

    // Hide all doctor sections first
    $(".department-doctors").slideUp();

    // Toggle the current one
    if (doctorSection.is(":visible")) {
      doctorSection.slideUp();
    } else {
      doctorSection.slideDown();
      $("html, body").animate(
        {
          scrollTop: doctorSection.offset().top - 100,
        },
        500
      );
    }
  });

  // View Profile button functionality
  $(".view-profile").click(function () {
    const doctorId = $(this).data("doctor");
    const doctor = doctors[doctorId];

    if (doctor) {
      $("#modalDoctorImg").attr("src", doctor.img);
      $("#modalDoctorName").text(doctor.name);
      $("#modalDoctorTitle").text(doctor.title);
      $("#modalDoctorBio").text(doctor.bio);
      $("#modalDoctorAvailability").text(doctor.availability);

      // Set education
      const educationList = $("#modalDoctorEducation").empty();
      doctor.education.forEach((edu) => {
        educationList.append(
          `<li><i class="fas fa-graduation-cap me-2 text-primary"></i>${edu}</li>`
        );
      });

      // Set specializations
      const specializations = $("#modalDoctorSpecializations").empty();
      doctor.specializations.forEach((spec) => {
        specializations.append(
          `<span class="badge bg-secondary me-2 mb-2">${spec}</span>`
        );
      });

      // Set badges
      const badges = $("#modalDoctorBadges").empty();
      doctor.badges.forEach((badge) => {
        badges.append(
          `<span class="badge ${badge.class} me-2">${badge.text}</span>`
        );
      });

      // Set appointment link
      $("#modalBookBtn").attr(
        "href",
        `appointment.html?doctor=${doctorId}`
      );

      // Show modal
      $("#doctorModal").modal("show");
    }
  });

  // Set copyright year
  $(".copyright-year").text(new Date().getFullYear());
});