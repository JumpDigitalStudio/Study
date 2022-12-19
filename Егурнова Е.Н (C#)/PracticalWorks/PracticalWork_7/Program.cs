using System;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Text;
using System.Threading.Tasks;

namespace PracticalWork_7
{
    internal class Program
    {
        static void Main(string[] args)
        {
            // Работу выполнил Кузнецов Илья Владиславович
            // Вариант номер 2


            Address address1 = new Address()
            {
                // Алгоритм заполнения экземпляров класса удаленных домов
                country = "Россия",
                city = "Оренбург",
                street = "7 линия",
                HouseNumber = 8,
                flat = 1,
            };

            Address address2 = new Address()
            {
                // Алгоритм заполнения экземпляров класса удаленных домов
                country = "Россия",
                city = "Оренбург",
                street = "проспект Дзержинского",
                HouseNumber = 14,
                flat = 72,
            };

            Address address3 = new Address()
            {
                // Алгоритм заполнения экземпляров класса удаленных домов
                country = "Россия",
                city = "Оренбург",
                street = "проспект Победы",
                HouseNumber = 158,
                flat = 56,
            };

            Address[] addresses = { address1, address2, address3 };
            Array.Sort(addresses);

            foreach (Address address in addresses)
            {
                address.GetAdress();
                Console.WriteLine();
            }

            // Вывод для iclonable

            /*
            ((address)adr1.Clone()).GetAdress();
            adr1.GetAdress();
            adr2.GetAdress();
            */

            Console.ReadKey();
        }
    }
}
