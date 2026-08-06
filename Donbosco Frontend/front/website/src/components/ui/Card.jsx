// src/components/ui/Card.jsx

const Card = ({ icon, title, description, className = '' }) => {
  return (
    <div className={`bg-white p-8 rounded-3xl shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 ${className}`}>
      {icon && (
        <div className="text-[#007BFF] mb-6 flex justify-end text-3xl">
          {icon}
        </div>
      )}
      <h3 className="text-xl font-bold text-[#1D1D1F] mb-3 text-right">
        {title}
      </h3>
      <p className="text-gray-600 text-right leading-relaxed text-sm md:text-base font-light">
        {description}
      
      </p>
    </div>
  );
};

export default Card;