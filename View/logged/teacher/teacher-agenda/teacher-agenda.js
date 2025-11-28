(function () {
  const calendarBody = document.getElementById("calendar-body");
  const monthSelect = document.getElementById("month");
  const yearInput = document.getElementById("year");
  const notesSection = document.getElementById("notes-section");
  const notesArea = document.getElementById("notes");
  const saveButton = document.getElementById("save-notes");

  let selectedDate = null;

 
  function getStorageKey(year, month, day) {
    return `agenda-notes-${year}-${month}-${day}`;
  }

 
  function loadNotes() {
    if (!selectedDate) return;
    const key = getStorageKey(selectedDate.year, selectedDate.month, selectedDate.day);
    notesArea.value = localStorage.getItem(key) || "";
  }


  function generateCalendar(year, month) {
    calendarBody.innerHTML = "";
    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    let date = 1;

    for (let i = 0; i < 6; i++) {
      const row = document.createElement("tr");

      for (let j = 0; j < 7; j++) {
        const cell = document.createElement("td");

        if (i === 0 && j < firstDay) {
          cell.textContent = "";
        } else if (date > daysInMonth) {
          cell.textContent = "";
        } else {
          
          const thisDate = date;
          cell.textContent = thisDate;

          
          cell.addEventListener("click", () => {
            document.querySelectorAll("td").forEach(td => td.classList.remove("today"));
            cell.classList.add("today");

            selectedDate = {
              year,
              month,
              day: thisDate
            };

            notesSection.style.display = "block";
            loadNotes(); 
          });

          date++;
        }

        row.appendChild(cell);
      }

      calendarBody.appendChild(row);
    }
  }

 
  saveButton.addEventListener("click", () => {
    if (!selectedDate) return;

    const key = getStorageKey(selectedDate.year, selectedDate.month, selectedDate.day);
    localStorage.setItem(key, notesArea.value);

    saveButton.textContent = "Salvo!";
    setTimeout(() => saveButton.textContent = "Salvar", 1200);
  });

  
  const today = new Date();
  generateCalendar(today.getFullYear(), today.getMonth());


  monthSelect.addEventListener("change", () => {
    generateCalendar(parseInt(yearInput.value), parseInt(monthSelect.value));
    notesSection.style.display = "none";
  });

  yearInput.addEventListener("input", () => {
    generateCalendar(parseInt(yearInput.value), parseInt(monthSelect.value));
    notesSection.style.display = "none";
  });
})();
