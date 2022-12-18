using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace PracticalWork_11
{
    internal class State
    {
        public string Text { get; set; } = "";
        public int FontSize { get; set; } = 8;
        public bool IsBold { get; set; } = false;
        public bool IsItalics { get; set; } = false;

        public bool IsUnderline { get; set; } = false;

        public State() { }
        public State(string text, int fontSize, bool bold, bool italic, bool underline)
        {
            Text = text;
            FontSize = fontSize;
            IsBold = bold;
            IsItalics = italic;
            IsUnderline = underline;
        }
    }
}
