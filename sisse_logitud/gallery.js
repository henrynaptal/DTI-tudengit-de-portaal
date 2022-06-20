// Projektiklass
class Project {
  constructor(title, author, content, id) {
    this.title = title;
    this.author = author;
    this.content = content;
  }
}

//Kasutajaliidese klass
class UI {
  static displayProjects() {
    const projects = Storage.getProjects();
    projects.forEach((project) => UI.addProject(project));
  }

  //Raamatu lisamine

  static addProject(project) {
    document.createElement("td");
    const projectList = document.querySelector("#project-list");
    const row = document.createElement("tr");
    if (project.read === true) {
      row.classList.add("read");
    }

    row.addEventListener("click", function () {
      UI.markAsRead(row);
    });

    row.innerHTML = `
        <td>${project.title}</td>
        <td>${project.author}</td>
        <td>${project.content}</td>
        <td><i class="fas fa-trash delete"></i></td>
    `;

    projectList.appendChild(row);

    UI.showAlerts("Projekt on edukalt lisatud galeriisse!", "success");
  }

  //Raamatu eemaldamine riiulist

  static deleteProject(target) {
    if (target.classList.contains("delete")) {
      target.parentElement.parentElement.remove();
      Storage.deleteProject(
        target.parentElement.previousElementSibling.previousElementSibling
          .previousElementSibling.textContent
      );
      UI.showAlerts("Projekt on galeriist kustutatud.", "info");
    }
  }

  //Märguanded

  static showAlerts(message, className) {
    const div = document.createElement("div");
    div.className = `alert alert-${className}`;
    div.appendChild(document.createTextNode(message));
    const container = document.querySelector("#container");
    const form = document.querySelector("#project-form");
    container.insertBefore(div, form);

    const infoalert = document.querySelector(".alert-info") !== null;
    const successalert = document.querySelector(".alert-success") !== null;
    if (infoalert) {
      setTimeout(() => document.querySelector(".alert-info").remove(), 5000);
    }

    if (successalert) {
      setTimeout(() => document.querySelector(".alert-success").remove(), 5000);
    }
  }

  static deleteAlerts() {
    document.querySelectorAll(".alert-danger").forEach((e) => e.remove());
  }

  static clear() {
    document.querySelector("#project-title").value = "";
    document.querySelector("#project-author").value = "";
    document.querySelector("#project-content").value = "";
  }
}

class Storage {
  static getProjects() {
    let projects;
    if (localStorage.getItem("projects") === null) {
      projects = [];
    } else {
      projects = JSON.parse(localStorage.getItem("projects"));
    }
    return projects;
  }

  static addProject(project) {
    const projects = Storage.getProjects();
    projects.push(project);
    localStorage.setItem("projects", JSON.stringify(projects));
  }

  static deleteProject(title) {
    const projects = Storage.getProjects();
    projects.forEach((project, index) => {
      if (project.title === title) {
        projects.splice(index, 1);
      }
    });

    localStorage.setItem("projects", JSON.stringify(projects));
  }
}

// Näitab raamatuid
document.addEventListener("DOMContentLoaded", UI.displayProjects);

// Lisa raamat
document.querySelector("#project-form").addEventListener("submit", (e) => {
  e.preventDefault();
  const title = document.querySelector("#project-title").value;
  const author = document.querySelector("#project-author").value;
  const content = document.querySelector("#project-content").value;
  

  let error = 0;
  if (title === "" && author === "" && page === "") {
    UI.showAlerts("Täida kõik väljad!", "danger");
    error++;
  } else if (author === "") {
    UI.showAlerts("Sisesta autor!", "danger");
    error++;
  } else if (content === "") {
    UI.showAlerts("Sisesta sisu!", "danger");
    error++;
  } else if (title === "") {
    UI.showAlerts("Sisesta pealkiri!", "danger");
    error++;
  } else {
    error = 0;
  }

  if (error === 0) {
    const project = new Project(title, author, content, false);

    UI.addProject(project);

    Storage.addProject(project);

    UI.clear();

    UI.deleteAlerts();
  }
});

document.querySelector("#project-list").addEventListener("click", (e) => {
  UI.deleteProject(e.target);
});