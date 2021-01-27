import React, { useState, useMemo, useCallback } from "react";
import { Slate, Editable, withReact } from "slate-react";
import { createEditor } from "slate";
import CustomEditor from "../editor";
import {
  FirstHeadElement,
  SecondHeadElement,
  ThirdHeadElement,
  DefaultElement,
  Leaf,
} from "./elements";

var TextEditor = () => {
  const editor = useMemo(() => withReact(createEditor()), []);

  const [value, setValue] = useState([
    { type: "paragraph", children: [{ text: "A line of text" }] },
  ]);

  var onChange = (newValue) => {
    setValue(newValue);
  };
  const renderElement = useCallback(({ attributes, children, element }) => {
    console.log({ ...element });
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
        CustomEditor.toggleBoldMark(editor);
        break;
      }
      case "i": {
        e.preventDefault();
        CustomEditor.toggleItalicMark(editor);
        break;
      }
      case "u": {
        e.preventDefault();
        CustomEditor.toggleUnderlineMark(editor);
      }
    }
  };
  return (
    <Slate editor={editor} value={value} onChange={onChange}>
      <Editable
        onKeyDown={onKeyDown}
        renderElement={renderElement}
        renderLeaf={renderLeaf}
      />
    </Slate>
  );
};
export default TextEditor;
