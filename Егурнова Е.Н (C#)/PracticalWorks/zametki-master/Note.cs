using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace zametki
{
    public class Note
    {
        public string Name { get; set; }
        public string Path { get; set; }
        public string Type { get; set; }
        public string Date { get; set; }
        public string Text { get; set; }

        public Note(string name, string path, string type, string date, string text)
        {
            Name = name;
            Path = path;
            Type = type;
            Date = date;
            Text = text;
        }

        public Note(string name, string path, string type, string date)
        {
            Name = name;
            Path = path;
            Type = type;
            Date = date;
        }
    }
}
