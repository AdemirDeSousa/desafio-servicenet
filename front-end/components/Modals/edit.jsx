import {
  Button,
  FormControl,
  FormLabel,
  Input,
  ModalBody,
  ModalHeader,
  Text,
} from "@chakra-ui/react";
import { useEffect, useState } from "react";
import { customAxios } from "../../service/axios";

const ModalEdit = ({ id }) => {
  const [values, setValues] = useState({});
  const [errors, setErrors] = useState({});

  useEffect(() => {
    const getUserById = () => {
      customAxios.get(`/usuarios/${id}`).then((res) => {
        setValues(res.data.data);
      });
    };

    getUserById();
  }, [id]);

  console.log(values);

  const onChange = (e) => {
    const value = e.target.value;
    const name = e.target.name;

    setValues({
      ...values,
      [name]: value,
    });
  };

  const onSubmit = (e) => {
    e.preventDefault();

    customAxios
      .put(`/usuarios/${id}`, values)
      .then(() => alert("Usuario atualizado com sucesso"))
      .catch((error) => {
        setErrors(error.response.data.data);
      });
  };

  return (
    <>
      <ModalHeader>Editar Usuario</ModalHeader>

      <ModalBody pb={6}>
        <form onSubmit={onSubmit}>
          <FormControl>
            <FormLabel>Matricula</FormLabel>
            <Input
              onChange={onChange}
              type={"text"}
              disabled
              value={values.enrollment}
            />
          </FormControl>
          <FormControl mt={4}>
            <FormLabel>Nome</FormLabel>
            <Input
              onChange={onChange}
              type={"text"}
              name="name"
              value={values.name}
              isInvalid={errors?.name}
            />
            {errors?.name && (
              <Text fontSize="sm" color="red.600">
                {errors.name.toString()}
              </Text>
            )}
          </FormControl>
          <FormControl mt={4}>
            <FormLabel>Data de Nascimento</FormLabel>
            <Input
              onChange={onChange}
              type={"date"}
              name="birthdate"
              value={values.birthdate}
              isInvalid={errors?.birthdate}
            />
            {errors?.birthdate && (
              <Text fontSize="sm" color="red.600">
                {errors.birthdate.toString()}
              </Text>
            )}
          </FormControl>
          <FormControl mt={4}>
            <FormLabel>Email</FormLabel>
            <Input
              onChange={onChange}
              type={"email"}
              name="email"
              value={values.email}
              isInvalid={errors?.email}
            />
            {errors?.email && (
              <Text fontSize="sm" color="red.600">
                {errors.email.toString()}
              </Text>
            )}
          </FormControl>
          <FormControl mt={4}>
            <FormLabel>Senha</FormLabel>
            <Input
              type={"password"}
              name="password"
              placeholder="Senha"
              onChange={onChange}
              isInvalid={errors?.password}
            />
            {errors?.password && (
              <Text fontSize="sm" color="red.600">
                {errors.password.toString()}
              </Text>
            )}
          </FormControl>
          <FormControl mt={4}>
            <FormLabel>Confirmar senha</FormLabel>
            <Input
              type={"password"}
              name="password_confirmation"
              placeholder="Confirmar senha"
              onChange={onChange}
            />
          </FormControl>
          <Button type="submit">Atualizar</Button>
        </form>
      </ModalBody>
    </>
  );
};

export default ModalEdit;
