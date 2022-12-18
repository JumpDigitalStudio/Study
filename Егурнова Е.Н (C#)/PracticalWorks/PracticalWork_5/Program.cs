using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace PracticalWork_5
{
    internal class Program
    {
        static void Main(string[] args)
        {
            var graph = new Graph(5);
            graph.Show();

            Console.WriteLine();

            graph.ReachabilityShow();
            Console.ReadKey();
        }
    }
}
