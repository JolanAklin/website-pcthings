import { Element } from "./Element.js";

export function Table(idPosition, id, destroyFunction, moveElement) {
  this.id = idPosition;
  this.destroyFunction = destroyFunction;
  this.mainDiv = document.createElement("DIV");

  this.addPositionNode = document.getElementById(idPosition);

  this.mainTextDiv = document.createElement("DIV");
  this.table = document.createElement("table");
  this.gridsdiv = document.createElement("table");
  this.ColumnsDiv = document.createElement("DIV");
  const CreateElement = (ev) => {
    this.mainDiv.appendChild(
      Element.prototype.CreateHeader(
        "Table Content",
        this.id,
        this.destroyFunction,
        this.mainDiv,
        moveElement
      )
    );
    this.mainDiv.className = "page-element input-table";

    this.mainDiv.appendChild(table);
  };
}

Table.prototype = new Element();
