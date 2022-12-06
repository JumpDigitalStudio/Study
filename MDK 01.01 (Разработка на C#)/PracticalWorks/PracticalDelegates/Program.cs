using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace PracticalDelegates
{
    internal class Program
    {
        // Объявляем делегат
        delegate void LambdaDelegate(int x, int y);

        static void Main(string[] args)
        {

            // Создаем переменную делегата
            LambdaDelegate del = (x, y) =>
            {
                if (x > y)
                {
                   Console.WriteLine(x - y);
                }
            };

            del = (x, y) =>
            {
                if (x < y)
                {
                    Console.WriteLine(x + y);
                }
            };


            del = (x, y) =>
            {
                if (x == y)
                {
                    Console.WriteLine(x * y);
                }
            };

            del(10, 2);
            Console.ReadLine();
        }
    }
}
