import { Element } from "./Element.js";

export function Table(idPosition, id, destroyFunction, moveElement) {
  console.log("hello");
  this.id = idPosition;
  this.destroyFunction = destroyFunction;
  this.mainDiv = document.createElement("DIV");

  this.addPositionNode = document.getElementById(idPosition);
  this.contentDiv = document.createElement("DIV");
  this.table = document.createElement("table");
  const createElement = (ev) => {
    console.log("create");
    this.mainDiv.appendChild(
      Element.prototype.CreateHeader(
        "Table",
        this.id,
        this.destroyFunction,
        this.mainDiv,
        moveElement
      )
    );
    this.mainDiv.className = "page-element";
    this.contentDiv.className = "page-element-input input-content";

    this.table.className = "input-table";
    let tr = document.createElement("tr");
    let td = document.createElement("td");
    tr.appendChild(td);
    td.contentEditable = true;
    this.table.appendChild(tr);
    this.table.addEventListener("keydown", (ev) => {
      switch (ev.key) {
        case "Tab":
          ev.preventDefault();
          this.AddTD();
          break;
        case "Enter":
          ev.preventDefault();
          this.AddTR();
          break;
      }
    });

    this.contentDiv.appendChild(this.table);

    this.mainDiv.appendChild(this.contentDiv);
    this.addPositionNode.appendChild(this.mainDiv);
  };
  Table.prototype.ToJson = function () {
    let content = [];
    let trs = this.table.childNodes;
    for (let tr in trs) {
      let tds = tr.childNodes;
    }
    return { Type: "Table", Content: content };
  };
  Table.prototype.FromJson = function (json) {
    this.gridsNumber.textContent = json.Content[0].gridsNumber;
  };
  Table.prototype.AddTD = function () {
    const selected = window.getSelection().focusNode.parentNode;
    if (selected.nodeName == "TD") {
      const td = document.createElement("TD");
      td.contentEditable = true;
      selected.parentNode.appendChild(td);
      td.focus();
    }
  };
  Table.prototype.AddTR = function () {
    const selected = window.getSelection().focusNode.parentNode;
    if (selected.nodeName == "TD") {
      const tr = document.createElement("TR");

      const td = document.createElement("TD");
      td.contentEditable = true;
      tr.appendChild(td);

      selected.parentNode.parentNode.appendChild(tr);
      td.focus();
    }
  };
  createElement();
}

Table.prototype = new Element();
