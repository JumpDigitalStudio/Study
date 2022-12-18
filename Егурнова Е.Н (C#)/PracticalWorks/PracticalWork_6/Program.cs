using System;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Text;
using System.Threading.Tasks;

namespace PracticalWork_6
{
    internal class Program
    {
        static void Main(string[] args)
        {
            // Работу выполнил Кузнецов Илья Владиславович
            // Вариант номер 2

            // Число экземпляров
            int obj = 5;
            // Число четных домов
            int evennumbered = 1;
            Random r = new Random();
            Address[] adr = new Address[obj];

            for (int j = 0; j < obj; j++)
            {
                // Алгоритм заполнения числа экземпляров
                adr[j] = new Address();
                adr[j].country = "Россия";
                adr[j].city = "Оренбург";
                adr[j].street = "Гагарина";
                adr[j].HouseNumber = r.Next(1, 999);

                if (adr[j].HouseNumber % 2 == 1)
                {
                    // Алгоритм проверки домов на четность
                    adr[j].HouseNumber = adr[j].HouseNumber + 1;

                    if (adr[j].HouseNumber % 2 != 1)
                    {
                        if (evennumbered > 0)
                        {
                            evennumbered--;
                        }
                        else
                        {
                            adr[j].HouseNumber = adr[j].HouseNumber - 1;
                        }
                    }
                }
                else
                if (adr[j].HouseNumber % 2 != 1)
                {
                    if (evennumbered > 0)
                    {
                        evennumbered--;
                    }
                    else
                    {
                        adr[j].HouseNumber = adr[j].HouseNumber - 1;
                    }
                }

                adr[j].FlatNumber = r.Next(1, 100);

                adr[j].GetAdress();
            }


            RemoteAdress ra1 = new RemoteAdress()
            { 
                // Алгоритм заполнения экземпляров класса удаленных домов
                country = "Россия",
                city = "Оренбург",
                street = "7 линия",
                HouseNumber = 8,
                flat = 1,
                reason = "Продан"
            };

            RemoteAdress ra2 = new RemoteAdress()
            {   
                // Алгоритм заполнения экземпляров класса удаленных домов
                country = "Россия",
                city = "Оренбург",
                street = "проспект Дзержинского",
                HouseNumber = 14,
                flat = 72,
                reason = "Арендован"

            };

            ra1.GetremoteAdress();
            Console.WriteLine();
            ra2.GetremoteAdress();

            Console.ReadKey();
        }
    }
}
