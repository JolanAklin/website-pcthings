import React, { useState, useMemo, useCallback } from "react";
import { Slate, Editable, withReact } from "slate-react";
import { createEditor } from "slate";
import { withHistory } from "slate-history";
import CustomEditor from "../editor";
import {
  FirstHeadElement,
  SecondHeadElement,
  ThirdHeadElement,
  DefaultElement,
  Leaf,
} from "./elements";

var TextEditor = () => {
  const editor = useMemo(() => withReact(withHistory(createEditor())), []);

  const [value, setValue] = useState([
    { type: "paragraph", children: [{ text: "A line of text" }] },
  ]);

  var onChange = (newValue) => {
    setValue(newValue);
  };
  const renderElement = useCallback(({ attributes, children, element }) => {
    switch (element.type) {
      case "h1":
        return <FirstHeadElement {...attributes}>{children}</FirstHeadElement>;
      case "h2":
        return (
          <SecondHeadElement {...attributes}>{children}</SecondHeadElement>
        );
      case "h3":
        return <ThirdHeadElement {...attributes}>{children}</ThirdHeadElement>;
      default:
        return <DefaultElement {...attributes}>{children}</DefaultElement>;
    }
  }, []);

  const renderLeaf = useCallback((props) => {
    return <Leaf {...props} />;
  }, []);
  var onKeyDown = (e, change) => {
    if (!e.ctrlKey) {
      return;
    }
    switch (e.key) {
      case "1": {
        e.preventDefault();
        CustomEditor.toggleHeading(editor, 1);
        break;
      }
      case "2": {
        e.preventDefault();
        CustomEditor.toggleHeading(editor, 2);
        break;
      }
      case "3": {
        e.preventDefault();
        CustomEditor.toggleHeading(editor, 3);
        break;
      }
      case "p": {
        e.preventDefault();
        CustomEditor.toggleDefault(editor);
        break;
      }
      case "b": {
        e.preventDefault();
        CustomEditor.toggleLeafMark(editor, "bold");
        break;
      }
      case "i": {
        e.preventDefault();
        CustomEditor.toggleLeafMark(editor, "italic");
        break;
      }
      case "u": {
        e.preventDefault();
        CustomEditor.toggleLeafMark(editor, "underlined");
      }
    }
  };
  return (
    <Slate editor={editor} value={value} {props.editable ? onChange={onChange} : ''}>
      <Editable
        onKeyDown={onKeyDown}
        renderElement={renderElement}
        renderLeaf={renderLeaf}
      />
    </Slate>
  );
};
export default TextEditor;
