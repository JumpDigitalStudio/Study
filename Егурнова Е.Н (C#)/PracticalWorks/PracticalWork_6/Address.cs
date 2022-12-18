using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace PracticalWork_6
{
    public class Address
    {
        public string country;
        public string city;
        public string street;
        public int house = 0;
        public int flat = 0;

        // Валидация значения номера дома
        public int HouseNumber
        {
            get => house;
            set
            {
                if (value >= 1 && value <= 999)
                {
                    house = value;
                }
                else
                    throw new InvalidCastException("Значение поля 'Номер дома' менее 1 или более 999.");
            }
        }

        // Валидация значения номера этажа
        public int FlatNumber
        {
            get => flat;
            set
            {
                if (value >= 1 && value <= 999)
                {
                    flat = value;
                }
                else
                    throw new InvalidCastException("Значение поля 'Номер этажа' менее 1 или более 999.");
            }
        }

        public void GetAdress()
        {
            Console.WriteLine(
                $"Страна: {country} \n" +
                $"Город: {city} \n" +
                $"Улица: {street} \n" +
                $"Дом: {house} \n" +
                $"Этаж: {flat} \n");
        }
    }
}
