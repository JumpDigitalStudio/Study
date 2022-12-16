using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace PracticWork9
{
    public class Individual : Phone
    {
        private string name;
        private long number;

        public Individual(string name, long number) { this.name = name; this.number = number; }

        public string GetInfo()
        {
            return "ИП: " + name + "\nНомер ИНН: " + number + "\n";
        }
    }
}
