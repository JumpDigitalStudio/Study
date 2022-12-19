using System;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Text;
using System.Threading.Tasks;

namespace PracticalWork_7
{
    public class Address : ICloneable, IComparable
    {
        public string country { get; set; }
        public string city { get; set; }
        public string street { get; set; }
        public int house { get; set; }
        public int flat { get; set; }

        public Address(string country, string city, string street, int house, int flat)
        {
            this.country = country;
            this.city = city;
            this.street = street;
            this.house = house;
            this.flat = flat;
        }

        public Address()
        {

        }

        public object Clone()
        {
            return new Address(this.country, this.city, this.street, this.house, this.flat);
        }

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

        public int CompareTo(object obj)
        {
            if (obj is Address addresses) return house.CompareTo(addresses.house);
            else throw new ArgumentException("Некорректное значение параметра");
        }

        object ICloneable.Clone()
        {
            throw new NotImplementedException();
        }
    }
}
