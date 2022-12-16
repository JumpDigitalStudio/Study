using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace PracticWork9
{
    internal class Institution : Phone
    {
        private string name;
        private long number;

        public Institution(string name, long number) { this.name = name; this.number = number; }

        public string GetInfo()
        {
            return "Образовательная организация: " + name + "\nНомер ИНН: " + number + "\n";
        }
    }
}
