using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace PracticalWork_6
{
    // Наследование класса
    internal class RemoteAdress : Address
    {
        // Добавление дополнительного поля
        public string reason = "";

        public void GetremoteAdress()
        {
            Console.WriteLine(
                $"Страна: {country} \n" +
                $"Город: {city} \n" +
                $"Улица: {street} \n" +
                $"Дом: {house} \n" +
                $"Этаж: {flat} \n" +
                $"Причина: {reason}");
        }
    }
}
