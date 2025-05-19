// Dynamic copyright year
      document.querySelector(".copyright-year").textContent =
        new Date().getFullYear();













      // Doctor section start

       // Doctor modal handling
       document.querySelectorAll(".view-profile-btn").forEach((button) => {
        button.addEventListener("click", function () {
          const doctorData = JSON.parse(this.getAttribute("data-doctor"));
          document.getElementById("doctorName").textContent = doctorData.name;
          document.getElementById("doctorSpecialty").textContent =
            doctorData.specialty;
          document.getElementById("doctorExperience").textContent =
            doctorData.experience;
          document.getElementById("doctorDescription").textContent =
            doctorData.description;
          document.getElementById("doctorImage").src = doctorData.image;
          document.getElementById("doctorEducation").textContent =
            doctorData.education;
          document.getElementById("doctorSchedule").textContent =
            doctorData.schedule;

          // Clear previous specializations
          const specializationsList = document.getElementById(
            "doctorSpecializations"
          );
          specializationsList.innerHTML = "";

          // Add specializations
          const specializations = doctorData.specialty.split(", ");
          specializations.forEach((spec) => {
            const li = document.createElement("li");
            li.textContent = spec;
            specializationsList.appendChild(li);
          });
        });
      });

      // Search and filter functionality
      document
        .getElementById("searchButton")
        .addEventListener("click", filterDoctors);
      document
        .getElementById("doctorSearch")
        .addEventListener("keyup", filterDoctors);
      document
        .getElementById("specialtyFilter")
        .addEventListener("change", filterDoctors);

      function filterDoctors() {
        const searchTerm = document
          .getElementById("doctorSearch")
          .value.toLowerCase();
        const specialtyFilter = document
          .getElementById("specialtyFilter")
          .value.toLowerCase();

        document.querySelectorAll("[data-specialty]").forEach((card) => {
          const doctorName = card
            .querySelector(".card-title")
            .textContent.toLowerCase();
          const doctorSpecialty = card
            .getAttribute("data-specialty")
            .toLowerCase();

          const nameMatch = doctorName.includes(searchTerm);
          const specialtyMatch =
            specialtyFilter === "" || doctorSpecialty.includes(specialtyFilter);

          if (nameMatch && specialtyMatch) {
            card.style.display = "block";
          } else {
            card.style.display = "none";
          }
        });
      }

      // doctor section end










      
      // appointment section start

       // Form validation
       (function () {
        "use strict";
        const form = document.getElementById("appointmentForm");

        form.addEventListener(
          "submit",
          function (event) {
            if (!form.checkValidity()) {
              event.preventDefault();
              event.stopPropagation();
            }

            form.classList.add("was-validated");

            if (form.checkValidity()) {
              // Form submission logic would go here
              alert(
                "Appointment booked successfully! We will contact you shortly."
              );
              form.reset();
              form.classList.remove("was-validated");
            }
          },
          false
        );
      })();

      // Set minimum date to today
      document.getElementById("date").min = new Date()
        .toISOString()
        .split("T")[0];

      // appointment section end